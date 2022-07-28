@foreach ($products as $product)
    <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
        <div class="product product-style-3 equal-elem ">
            <div class="product-thumnail">
                <a href="{{ route('product.detail', $product->slug) }}" title="{{ $product->name }}">
                    <figure><img src="{{ asset('assets/images/products') }}/{{ $product->image }}"
                            alt="{{ $product->slug }}"></figure>
                </a>
            </div>
            <div class="product-info">
                <a href="#" class="product-name"><span>{{ $product->name }}</span></a>
                <div class="wrap-price"><span class="product-price">{{ $product->regular_price }}</span></div>
                <a href="{{ route('add.to.cart', $product->id) }}" class="btn add-to-cart">Add To
                    Cart</a>
            </div>
        </div>
    </li>
@endforeach
