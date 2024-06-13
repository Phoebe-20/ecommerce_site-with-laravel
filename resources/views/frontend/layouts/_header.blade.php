<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <div class="header-dropdown">
                    <a href="#">cfa</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">cfa</a></li>
                            <li><a href="#">Euro</a></li>
                            <li><a href="#">Dollar</a></li>
                        </ul>
                    </div>
                </div>

                <div class="header-dropdown">
                    <a href="#">Français</a>
                    <div class="header-menu">
                        <ul>
                            <li><a href="#">Anglais</a></li>
                            <li><a href="#">Français</a></li>
                            <li><a href="#">Espagnole</a></li>
                            <li><a href="#">Arabe</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="header-right">
                <ul class="top-menu">
                    <li>
                        <a href="#">Links</a>
                        <ul>
                            <li><a href="{{ url('wishlist') }}"><i class="icon-heart-o"></i>Favoris <span>(3)</span></a></li>
                            <li><a href="{{ url('about') }}">A Propos</a></li>
                            <li><a href="{{ url('contact') }}">Contact</a></li>
                            @if (!empty(Auth::check()))
                                <li><a href="{{ url('admin/logout') }}"><i class="icon-user"></i>Se Déconnecter</a></li>
                            @else 
                                <li><a href="#signin-modal" data-toggle="modal"><i class="icon-user"></i>Connection</a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ url('') }}" class="logo">
                    <img src="{{ url('assets/images/logo.png') }}" alt="" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="active">
                            <a href={{ url('') }}>Accueil</a>
                        </li>
                        <li>
                            <a href="javascript:;" class="sf-with-ul">Boutique</a>

                            <div class="megamenu megamenu-md">
                                <div class="row no-gutters">
                                    <div class="col-md-12">
                                        <div class="menu-col">
                                            <div class="row">
                                                @php
                                                    $getCategoryHeader = App\Models\Category::getRecordMenu();
                                                @endphp
                                                
                                                @foreach ($getCategoryHeader as $value_category_header)     
                                                    @if (!@empty($value_category_header->getSubcategory->count()))
                                                        <div class="col-md-4" style="margin-bottom: 20px">
                                                            <a href="{{ url($value_category_header->slug) }}" class="menu-title">{{ $value_category_header->name }}</a>
                                                            <ul>
                                                                @foreach ($value_category_header->getSubcategory as $value_h_sub)
                                                                    <li><a href="{{ url($value_category_header->slug.'/'.$value_h_sub->slug) }}">{{ $value_h_sub->name }}</a></li>                                                    
                                                                @endforeach
                                                            </ul>   
                                                        </div>
                                                    @endif
                                                @endforeach    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                    <form action="{{ url('search') }}" method="get">
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Recherce</label>
                            <input type="search" class="form-control" name="q" id="q" placeholder="Recherche dans..."
                                value="{{ !empty(Request::get('q')) ? Request::get('q') : '' }}" required>
                        </div>
                    </form>
                </div>

                <div class="dropdown cart-dropdown">
                    <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                        <i class="icon-shopping-cart"></i>
                        <span class="cart-count">{{ Cart::getContent()->count() }}</span>
                    </a>

                    @if (!empty(Cart::getContent()->count()))
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-cart-products">
                                @foreach (Cart::getContent() as $header_cart)
                                    @php
                                        $getCartProduct = App\Models\Product::getSingle($header_cart->id);
                                    @endphp

                                    @if (!empty($getCartProduct))
                                        @php
                                            $getProductImage = $getCartProduct->getImageSingle($getCartProduct->id);
                                        @endphp
                                        <div class="product">
                                            <div class="product-cart-details">
                                                <h4 class="product-title">
                                                    <a href="{{ url($getCartProduct->slug) }}">{{ $getCartProduct->title }}</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">{{$header_cart->quantity}}</span>
                                                    x cfa{{ number_format($header_cart->price, 2) }} 
                                                </span>
                                            </div>

                                            <figure class="product-image-container">
                                                <a href="product.html" class="product-image">
                                                    <img src="{{ $getProductImage->getLogo() }}" alt="product">
                                                </a>
                                            </figure>
                                            <a href="{{ 'cart/delete/'.$header_cart->id }}" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="dropdown-cart-total">
                                <span>Total</span>

                                <span class="cart-total-price">cfa{{ number_format(Cart::getSubTotal(), 2) }}</span>
                            </div>

                            <div class="dropdown-cart-action">
                                <a href="{{ url('cart') }}" class="btn btn-primary">Voir le Panier</a>
                                <a href="{{ url('checkout') }}" class="btn btn-outline-primary-2"><span>Paiement</span><i class="icon-long-arrow-right"></i></a>
                            </div>
                        </div>
                    @endif             
                </div>
            </div>
        </div>
    </div>
</header>