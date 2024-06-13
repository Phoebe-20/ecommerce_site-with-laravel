<div class="products mb-3">
    <div class="row justify-content-center">
            @foreach ( $getProduct as $value ) 
                @php
                    $getProductImage = $value->getImageSingle($value->id);
                @endphp 

            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                <div class="product product-7 text-center">
                    <figure class="product-media">
                        <a href="{{ url($value->slug) }}">
                            @if(!empty($getProductImage) && !empty($getProductImage->getLogo()))
                                <img style="height: 100%;width: 100%;object-fit: cover;" src="{{ $getProductImage->getLogo() }}" 
                                    alt="{{ $value->title }}" class="product-image">
                            @endif
                        </a>

                        <div class="product-action-vertical">
                            <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>Ajouter aux Favories</span></a>
                            <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Comparer</span></a>
                        </div>

                        <div class="product-action">
                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                        </div>
                    </figure>

                    <div class="product-body">
                        <div class="product-cat">
                            <a href="{{ url($value->category_slug.'/'.$value->subcategory_slug) }}">{{ $value->subcategory_name }}</a>
                        </div>
                        <h3 class="product-title">
                            <a href="{{ url($value->slug) }}">{{ $value->title }}</a>
                        </h3>
                        <div class="product-price">
                            cfa {{ number_format($value->price, 2) }}
                        </div>
                        <div class="ratings-container">
                            <div class="ratings">
                                <div class="ratings-val" style="width: 20%;"></div>
                            </div>
                            <span class="ratings-text">( 2 Reviews )</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
    </div>
</div>

