<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ShippingCharge;
use App\Models\User;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function apply_discount_code(Request $request)
    {
        $getDiscount = DiscountCode::CheckDiscount($request->discount_code);
        if (!empty($getDiscount)) 
        {
            $total = Cart::getSubTotal();
            if ($getDiscount->type == 'Amount') 
            {
                $discount_amount = $getDiscount->percent_amount;
                $payable_total = $total - $getDiscount->percent_amount;
            }
            else
            {
                $discount_amount = ($total * $getDiscount->percent_amount) / 100;
                $payable_total = $total - $discount_amount;
            }

            $json['status'] = true;
            $json['discount_amount'] = number_format($discount_amount, 2);
            $json['payable_total'] = $payable_total;
            $json['message'] = "Code de Réduction Valide";
        }
        else 
        {
           $json['status'] = false;
           $json['discount_amount'] = '0.00';
           $json['payable_total'] = Cart::getSubTotal();
           $json['message'] = "Code de Réduction Invalide";
        }

        echo json_encode($json);
    }

    public function checkout(Request $request)
    {
        $data['meta_title'] = 'Paiement';
        $data['meta_description'] = '';
        $data['meta_keywords'] = '';
        $data['getShipping'] = ShippingCharge::getRecordActive();
        return view('frontend.payment.checkout', $data);
    }

    public function cart(Request $request)
    {
        $data['meta_title'] = 'Panier';
        $data['meta_description'] = '';
        $data['meta_keywords'] = '';
        return view('frontend.payment.cart', $data);
    }

    public function cart_delete($id)
    {
        Cart::remove($id); 
        
        return redirect()->back();
    }

    public function add_to_cart(Request $request)
    {
        $getProduct = Product::getSingle($request->product_id);
        $total = $getProduct->price;
        if (!empty($request->size_id)) 
        {
           $size_id = $request->size_id;
           $getSize = ProductSize::getSingle($size_id);

           $size_price = !empty($getSize->price) ? $getSize->price : 0;
           $total = $total + $size_price;
        }
        else 
        {
            $size_id = 0;
        }

        $color_id = !empty($request->color_id) ? $request->color_id : 0;

        Cart::add([
            'id' => $getProduct->id,
            'name' => 'Product',
            'price' => $total,
            'quantity' => $request->qty,
            'attributes' => array(
                'size_id' => $size_id,
                'color_id' => $color_id,
            )
        ]);

        return redirect()->back();
    }


    public function update_cart(Request $request)
    {
        foreach($request->cart as $cart)
        {
            Cart::update($cart['id'], array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $cart['qty']
                ),
            ));
        } 

        return redirect()->back();
    }

    public function place_order(Request $request)
    {
        $validate = 0;
        $message = '';
        if (!empty(Auth::check())) 
        {
            $user_id = Auth::user()->id;
        } 
        else 
        {
            if (!empty($request->is_create)) 
            {
                $checkEmail = User::checkEmail($request->email);
                if (!empty($checkEmail)) 
                {
                    $validate = 1;
                    $message = "Cette AddresseMail existe déjà.
                                    Veuillez entrer une autre addresse"; 
                } 
                else 
                {
                    $save = new User;
                    $save->name = $request->first_name;
                    $save->email = $request->email;
                    $save->password = Hash::make( $request->password);
                    $save->save(); 
                    
                    $user_id = $save->id;
                }
            }
            else
            {
                $user_id = '';
            }
        }

        if (empty($validate)) 
        {
            $getShipping = ShippingCharge::getSingle($request->shipping);
            $payable_total = Cart::getSubTotal();
            $discount_amount = 0;
            $discount_code = '';
    
            if (!empty($request->discount_code)) 
            {
                $getDiscount = DiscountCode::CheckDiscount($request->discount_code);
                if (!empty($getDiscount)) 
                {
                    $discount_code = $request->discount_code;
                    if ($getDiscount->type == 'Amount') 
                    {
                        $discount_amount = $getDiscount->percent_amount;
                        $payable_total = $payable_total - $getDiscount->percent_amount;
                    }
                    else
                    {
                        $discount_amount = ($payable_total * $getDiscount->percent_amount) / 100;
                        $payable_total = $payable_total - $discount_amount;
                    }
                }   
            } 
            
            $shipping_amount = !empty($getShipping->price) ? $getShipping->price : 0;
            $total_amount = $payable_total + $shipping_amount;
    
            $order = new Order;
            if (!empty($user_id)) 
            {
                $order->user_id = $user_id;
            }
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->company_name = $request->company_name;
            $order->country = $request->country;
            $order->address_one = $request->address_one;
            $order->address_two = $request->address_two;
            $order->city = $request->city;
            $order->county = $request->county;
            $order->postcode = $request->postcode;
            $order->phone = $request->phone;
            $order->email = $request->email;
            $order->note = $request->note;
            $order->discount_code = $discount_code;
            $order->discount_amount = $discount_amount;
            $order->shipping_id = $request->shipping;
            $order->shipping_amount = $shipping_amount;
            $order->total_amount = $total_amount;
            $order->payment_method = $request->payment_method;
            $order->save();
    
    
            foreach (Cart::getContent() as $key => $cart)
            {
                $order_item = new OrderItem;
                $order_item->order_id = $order->id;
                $order_item->product_id = $cart->id;
                $order_item->quantity = $cart->quantity;
                $order_item->price = $cart->price;
                //dd($cart);
    
                $color_id = $cart->attributes->color_id;
                if (!empty($color_id))
                {
                    $getColor = Color::getSingle($color_id);
                    $order_item->color_name = $getColor->name;
                }
                
                $size_id = $cart->attributes->size_id;
                if (!empty($size_id)) 
                {
                    $getSize = ProductSize::getSingle($size_id);
                    $order_item->size_name =  $getSize->name;
                    $order_item->size_amount =  $getSize->price;
                }
    
                $order_item->total_price = $cart->price;
                $order_item->save();
    
            }

            $json['status'] = true;
            $json['message'] = "Commande passée avec success";
            $json['redirect'] = url('checkout/payment?order_id='.base64_encode($order->id));
        } 
        else
        {
            $json['status'] = false;
            $json['message'] = $message;
        }  

        echo json_encode($json);
    } 
        
    public function checkout_payment(Request $request) 
    {
        if (!empty(Cart::getSubTotal()) && !empty($request->order_id)) 
        {
            $order_id = base64_decode($request->order_id);
            $getOrder = Order::getSingle($order_id);
            if (!empty($getOrder)) 
            {
                if ($getOrder->payment_method == 'cash') 
                {
                    $getOrder->is_payment = 1;
                    $getOrder->save();

                    Cart::clear();

                    return redirect('cart')->with('success', "Votre commande a réussie");
                } 
                else if($getOrder->payment_method == 'paypal')
                {
                    $query                  = array();
                    $query['business']      = "mollaplatform@gmail.com";    //"mtbikoi03@gmail.com";    
                    $query['cmd']           = '_xclick';
                    $query['item_name']     = "Molla.com";
                    $query['no_shipping']   = '1';
                    $query['item_number']   = $getOrder->id;
                    $query['amount']        = $getOrder->total_amount;
                    $query['currency_code'] = 'XFA';
                    $query['cancel_return'] = url('checkout');
                    $query['return']        = url('paypal/success-payment');

                    $query_string = http_build_query($query);

                    header('Location: https://www.sandbox.paypal.com./cgi-bin/webscr?' . $query_string);
                    //header('Location: https://www.paypal.com./cgi-bin/webscr?'. $query_string);
                    exit();

                }
                else if($getOrder->payment_method == 'stripe')
                {
                    Stripe::setApiKey(env('STRIPE_SECRET'));
                    $finalprice = $getOrder->total_amount * 100;

                    $session = \Stripe\Checkout\Session::create([
                        'customer_email' => $getOrder->email,
                        'payment_method_types' => ['card'],
                        'line_items' => [[
                            'price_data' => [
                                'currency' => 'XFA',
                                'product_data' => [
                                    'name' => 'Molla.com',
                                ],                                    
                                'unit_amount' => intval($finalprice),
                            ],
                            'quantity' => 1,
                         ]],
                         'mode' => 'payment',
                         'success_url' => url('stripe/payment-success'),
                            'cancel_url' => url('checkout'),
                    ]);
                    //dd($session); 

                    $getOrder->stripe_session_id = $session['id'];
                    $getOrder->save();

                    $data['session_id'] = $session['id'];
                    Session::put('stripe_session_id', $session['id']);
                    $data['setPublicKey'] = env('STRIPE_KEY');

                    return view('payment.stripe_charge', $data);
                }                
            } 
            else 
            {
                abort(404);
            }            
        }
        else
        {
            abort(404);
        }
        //die;
    }

    public function paypal_success_payment(Request $request)
    {
        //dd($request->all());
        if (!empty($request->item_number) && !empty($request->st) && $request->st == 'Completed')
        {
            
           $getOrder = Order::getSingle($request->item_number);
           if (!empty($getOrder)) 
           {
                $getOrder->is_payment = 1;
                $getOrder->transaction_id = $request->tx;
                $getOrder->payment_data = json_encode($request->all());
                $getOrder->save();

                Cart::clear();

                return redirect('cart')->with('success', "Votre commande a réussie");
           } 
           else 
           {
                abort(404);
           }
           
        }
        else 
        {
            abort(404);
        }

        
    }
}
