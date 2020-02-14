<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-success">
        <i class="fa fa-check"></i>
        <h3>{{__('Item added to your cart!')}}</h3>
    </div>
    <div class="product-box">
        <div class="block">
            <div class="row">
                <div class="col-4">
                    <img src="{{ asset($product->thumbnail_img) }}" class="img-fluid" alt="Product Image">
                </div>
                <div class="col-8">
                    <h6>{{ __($product->name) }}</h6>
                    <strong class="text-black">Price : {{ single_price($data['price']*$data['quantity']) }}</strong>
                    <div class="mt-2">
                        <strong class="text-dark">
                            <h6>{{ $data['start_date']}} s/d {{ $data['end_date'] }}</h6>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-default btn-outline btn-circle mb-3 mb-sm-0" data-dismiss="modal">
            <i class="la la-mail-reply"></i> {{__('Back to shopping')}}
        </button>
        <a href="{{ route('cart') }}" class="btn btn-orange btn-circle mb-3 mb-sm-0">
            <i class="fa fa-location-arrow"></i> {{__('Proceed to Checkout')}}
        </a>
    </div>
</div>