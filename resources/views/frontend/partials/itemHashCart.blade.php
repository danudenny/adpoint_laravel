<div class="modal-body p-4 added-to-cart">
    <div class="text-center text-info">
        <h1><i class="fa fa-info-circle"></i></h1>
        <h2>{{__('oops..')}}</h2>
        <h3>
            <strong>{{__('This item is already in the cart')}}</strong>
        </h3>
    </div>
    <div class="text-center mt-5">
        <a href="{{ route('cart') }}" class="btn btn-info btn-circle">
            <i class="fa fa-edit"></i> {{__('Edit Your Cart')}}
        </a>
    </div>
</div>
