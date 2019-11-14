<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-success">
        <i class="fa fa-check"></i>
        <h3>{{__('Item added to your cart!')}}</h3>
    </div>
    <div class="product-box">
        <div class="block">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ asset($product->thumbnail_img) }}" class="img-fluid img-thumbnail" alt="Product Image">
                </div>
                <div class="col-md-8">
                    <h6>{{ __($product->name) }}</h6>
                    <strong class="text-black">Price : {{ single_price($data['price']*$data['quantity']) }}</strong>
                    <div id="startendDate">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button class="btn btn-styled btn-base-1 btn-outline mb-3 mb-sm-0" data-dismiss="modal">{{__('Back to shopping')}}</button>
        <a href="{{ route('cart') }}" class="btn btn-styled btn-base-1 mb-3 mb-sm-0">{{__('Proceed to Checkout')}}</a>
    </div>
</div>
