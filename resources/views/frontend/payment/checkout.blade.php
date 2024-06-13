@extends('frontend.layouts.app')

@section('style')
@endsection

@section('content')

    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Paiement<span>Boutique</span></h1>
            </div>
        </div>
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="#">Boutique</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Paiement</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="checkout">
                <div class="container">
                    <form action="" id="SubmitForm" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-9">
                                <h2 class="checkout-title">Détails de facturation</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Nom *</label>
                                            <input type="text" name="first_name" class="form-control" required>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Prénom *</label>
                                            <input type="text" name="last_name" class="form-control" required>
                                        </div>
                                    </div>

                                    <label>Nom de l'entreprise (facultatif)</label>
                                    <input type="text" name="company_name" class="form-control">

                                    <label>Pays *</label>
                                    <input type="text" name="country" class="form-control" required>

                                    <label>Adresse postale *</label>
                                    <input type="text" name="address_one" class="form-control" placeholder="Numéro de maison et nom de la rue" required>
                                    <input type="text" name="address_two" class="form-control" placeholder="Appartements, suite, etc ..." required>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Ville *</label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Région *</label>
                                            <input type="text" name="county" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Code postal *</label>
                                            <input type="text" name="postcode" class="form-control" >
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Téléphone *</label>
                                            <input type="tel" name="phone" class="form-control" required>
                                        </div>
                                    </div>

                                    <label>Adresse Mail *</label>
                                    <input type="email" name="email" class="form-control" required>

                                    @if (empty(Auth::check()))
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="is_create" class="custom-control-input createAccount" id="checkout-create-acc">
                                            <label class="custom-control-label" for="checkout-create-acc">Créer un compte ?</label>
                                        </div>

                                        <div id="showPassword" style="display: none;">
                                            <label>Mot de passe *</label>
                                            <input type="text" id="inputPassword" name="password" class="form-control">
                                        </div>
                                    @endif

                                    <label>Notes de commande (facultatif)</label>
                                    <textarea class="form-control" name="note" cols="30" rows="4" placeholder="Remarques sur votre commande, par exemple des notes spéciales pour la livraison"></textarea>
                            </div>

                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Votre commande</h3>

                                    <table class="table table-summary">
                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::getContent() as $key => $cart)
                                                @php
                                                    $getCartProduct = App\Models\Product::getSingle($cart->id);
                                                @endphp
                                                <tr>
                                                    <td><a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a></td>
                                                    <td>cfa{{ number_format($cart->price * $cart->quantity, 2 ) }}</td>
                                                </tr>
                                            @endforeach
                                            
                                            <tr class="summary-subtotal">
                                                <td>Sous-total:</td>
                                                <td>cfa{{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>

                                            <tr>
                                                <td colspan="2">
                                                    <div class="cart-discount">
                                                        <div class="input-group">
                                                            <input type="text" name="discount_code" id="getDiscountCode" class="form-control" placeholder="Code de réduction">
                                                            <div class="input-group-append">
                                                                <a id="ApllyDiscount" style="height: 40px;" class="btn btn-outline-primary-2" type="submit"><i class="icon-long-arrow-right"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Rabais:</td>
                                                <td>cfa<span id="getDiscountAmount">0.00</span></td>
                                            </tr>

                                            <tr class="summary-shipping">
	                							<td>Livraison:</td>
	                							<td>&nbsp;</td>
	                						</tr>
                                            @foreach ($getShipping as $shipping)    
                                                <tr class="summary-shipping-row">
                                                    <td>
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" value="{{ $shipping->id }}" id="free-shipping{{ $shipping->id }}" name="shipping" required data-price="{{ !empty($shipping->price) ? $shipping->price : 0 }}" class="custom-control-input getShippingCharge">
                                                            <label class="custom-control-label" for="free-shipping{{ $shipping->id }}">{{ $shipping->name }}</label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if(!empty($shipping->name)) 
                                                            cfa{{ number_format($shipping->price, 2) }}    
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>cfa<span id="getPayableTotal">{{ number_format(Cart::getSubTotal(), 2) }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <input type="hidden" id="getShippingChargeTotal" value="0">
                                    <input type="hidden" id="PayableTotal" value="{{ Cart::getSubTotal() }}">
                                    <div class="accordion-summary" id="accordion-payment">

                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="cash" id="cacheondelivery" name="payment_method" required class="custom-control-input">
                                            <label for="cacheondelivery" class="custom-control-label">Paiement à la livraison</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="paypal" id="PayPal" name="payment_method" required class="custom-control-input">
                                            <label class="custom-control-label" for="PayPal">PayPal</label>
                                        </div>

                                        <div class="custom-control custom-radio">
                                            <input type="radio" value="stripe" id="creditcard" name="payment_method" required class="custom-control-input">
                                            <label class="custom-control-label" for="creditcard">Carte de crédit (Stripe)</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-outline-primary-2 btn-order btn-block">
                                        <span class="btn-text">Passer la commande</span>
                                        <span class="btn-hover-text">Passer à la caisse</span>
                                    </button>
                                    <br /><br />
                                    <img src="{{ url('assets/images/payments-summary.png') }}">
                                </div>
                            </aside>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')

    <script type="text/javascript">

        $('body').delegate('.createAccount', 'change', function() 
        {
            if (this.checked) 
            {
                $('#showPassword').show();
                $("#inputPassword").prop('required', true);
            } 
            else 
            {
                $('#showPassword').hide();
                $("#inputPassword").prop('required', false);
            }
        });


        $('body').delegate('#SubmitForm', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type : "POST",
                url : "{{ url('checkout/place_order') }}",
                data :
                    new FormData(this),
                    "_token": "{{ csrf_token() }}",
                processData:false,
                contentType:false,
                dataType: "json",
                success: function(data) {
                    if(data.status == false)
                    {
                        alert(data.message);
                    }
                    else
                    {
                        window.location.href = data.redirect;
                    }
                },
                error: function(data) {
                    
                }
            });
        });


        $('body').delegate('.getShippingCharge', 'change', function() 
        {
            var price = $(this).attr('data-price');
            var total = $('#PayableTotal').val();
            $('#getShippingChargeTotal').val(price);
            var final_total = parseFloat(price) + parseFloat(total);
            $('#getPayableTotal').html(final_total.toFixed(2));

        });

        // Requête de validation du code de reduction
        $('body').delegate('#ApllyDiscount', 'click', function() {
            var discount_code = $('#getDiscountCode').val();

            $.ajax({
                type : "POST",
                url : "{{ url('checkout/apply_discount_code') }}",
                data : {
                    discount_code : discount_code,
                    "_token": "{{ csrf_token() }}",
                },
                dataType : "json",
                success: function (data) {
                    $('#getDiscountAmount').html(data.discount_amount);
                    var shipping = $('#getShippingChargeTotal').val();

                    var final_total = parseFloat(shipping) + parseFloat(data.payable_total);

                    $('#getPayableTotal').html(final_total.toFixed(2));
                    $('#PayableTotal').val(data.payable_total);

                    if (data.status == false) 
                    {
                        alert(data.message);
                    }

                },
                error: function (data) {
                        
                }
            });
            
        });
    </script>

@endsection