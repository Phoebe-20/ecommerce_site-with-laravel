@extends('frontend.layouts.app')

@section('style')
@endsection

@section('content')

    <main class="main">
        <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
            <div class="container">
                <h1 class="page-title">Panier<span>Boutique</span></h1>
            </div>
        </div>
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="#">Boutique</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Panier</li>
                </ol>
            </div>
        </nav>

        <div class="page-content">
            <div class="cart">
                <div class="container">

                    @include('frontend.layouts._message')

                    @if (!empty(Cart::getContent()->count()))    
                        <div class="row">
                            <div class="col-lg-9">
                                <form action="{{ url('update_cart') }}" method="post">
                                    {{ csrf_field() }}
                                    <table class="table table-cart table-mobile">
                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Prix</th>
                                                <th>Quantité</th>
                                                <th>Total</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (Cart::getContent() as $key => $cart)
                                                @php
                                                    $getCartProduct = App\Models\Product::getSingle($cart->id);
                                                @endphp

                                                @if (!empty($getCartProduct))
                                                    @php
                                                        $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                                    @endphp
                                                    <tr>
                                                        <td class="product-col">
                                                            <div class="product">
                                                                <figure class="product-media">
                                                                    <a href="{{ url($getCartProduct->slug) }}">
                                                                        <img src="{{ $getProductImage->getLogo() }}" alt="Product image">
                                                                    </a>
                                                                </figure>

                                                                <h3 class="product-title">
                                                                    <a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a>
                                                                </h3>
                                                            </div>
                                                        </td>
                                                        <td class="price-col">cfa{{ number_format($cart->price, 2) }} </td>
                                                        <td class="quantity-col">
                                                            <div class="cart-product-quantity">
                                                                <input type="number" class="form-control" value="{{$cart->quantity}}" min="1" max="100" name="cart[{{ $key }}][qty]" step="1" data-decimals="0" required>
                                                                <input type="hidden" value="{{$cart->id}}" name="cart[{{ $key }}][id]" >
                                                            </div>
                                                        </td>
                                                        <td class="total-col">cfa{{ number_format($cart->price * $cart->quantity, 2 ) }}</td>
                                                        <td class="remove-col"><a  href="{{ 'cart/delete/'.$cart->id }}" class="btn-remove"><i class="icon-close"></i></a></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="cart-bottom">
                                        <button type="submit" class="btn btn-outline-dark-2"><span>METTRE À JOUR LE PANIER</span><i class="icon-refresh"></i></button>
                                    </div>
                                </form>
                            </div>
                            
                            <aside class="col-lg-3">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Total du panier</h3>

                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-subtotal">
                                                <td>Sous-total:</td>
                                                <td>cfa{{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>cfa{{ number_format(Cart::getSubTotal(), 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2 btn-order btn-block">PROCEDER AU PAIEMENT</a>
                                </div>

                                <a href="{{ url('') }}" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUER DANS LA BOUTIQUE</span><i class="icon-refresh"></i></a>
                            </aside>
                        </div>
                    @else
                        <p>Le Panier est vide !</p>
                    @endif
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')
@endsection