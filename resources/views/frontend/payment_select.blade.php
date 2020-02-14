@extends('frontend.layouts.app')

@section('content')

    <div id="page-content">
        <section class="slice-xs sct-color-2 border-bottom">
            <div class="container container-sm">
                <div class="row cols-delimited">
                    <div class="col-4">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-shopping-cart"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{__('My Cart')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-truck"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2. {{__('Billing info')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon mb-0">
                                <i class="la la-credit-card" style="color: #ff9400"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">4. {{__('Payment')}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <section class="py-3 gry-bg">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        <form action="{{ route('payment.checkout') }}" class="form-default" data-toggle="validator" role="form" method="POST" id="checkout-form">
                            @csrf
                            <div class="card">
                                <div class="card-title px-4 py-3">
                                    <h3 class="heading heading-5 strong-500">
                                        {{__('Select a payment option')}}
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                @if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                                                    <div class="col-md-6">
                                                        <label class="payment_option mb-4" data-toggle="tooltip" data-title="Bank Mandiri">
                                                            <input type="radio" id="mandiri" name="payment_option" value="Mandiri">
                                                            <span style="width: 150px;">
                                                                <img src="{{ asset('frontend/images/icons/cards/mandiri.png')}}" class="img-fluid">
                                                            </span>
                                                        </label>
                                                        <label class="payment_option mb-4" data-toggle="tooltip" data-title="Bank BCA">
                                                            <input type="radio" id="bca" name="payment_option" value="BCA">
                                                            <span style="width: 150px;">
                                                                <img src="{{ asset('frontend/images/icons/cards/bca.png')}}" class="img-fluid">
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="detailbank">
                                                            
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row align-items-center pt-4">
                                <div class="col-6">
                                    <a href="{{ route('home') }}" class="btn btn-danger btn-circle">
                                        <i class="la la-mail-reply"></i>
                                        {{__('Return to shop')}}
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="submit" id="complete" style="cursor: not-allowed" class="btn btn-orange btn-circle" disabled>
                                        <i class="fa fa-location-arrow"></i> {{__('Place Order')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 ml-lg-auto">
                        @include('frontend.partials.cart_summary')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function use_wallet(){
            $('input[name=payment_option]').val('wallet');
            $('#checkout-form').submit();
        }

        function enabledbutton(){
            $('#complete').prop('disabled', false);
            $('#complete').removeAttr('style');
        }

        $('#mandiri').on('click', function(){
            enabledbutton();
            var body = `<div class="card border-dark mb-3" style="max-width: 18rem;">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Bank Mandiri</h5>
                                <h5 class="card-title">13300290929</h5>
                                <p class="card-text">PT. Adpoint Media Online</p>
                            </div>
                        </div>`
            $('#detailbank').html(body);
        })
        $('#bca').on('click', function(){
            enabledbutton();
            var body = `<div class="card border-dark mb-3" style="max-width: 18rem;">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Bank BCA</h5>
                                <h5 class="card-title">14090279782</h5>
                                <p class="card-text">PT. Adpoint Media Online</p>
                            </div>
                        </div>`
            $('#detailbank').html(body);
        })
    </script>
@endsection
