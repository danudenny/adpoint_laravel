@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Transaction')}}
                                    </h2>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('trx.page.buyer') }}">{{__('Transaction')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (Session::has('message'))
                            <div class="alert alert-success">
                                {!! session('message') !!}
                            </div>
                        @endif
                        
                        <div class="row no-border mt-4">
                            <div class="col-md-12">
                                <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-unpaid-tab" data-url="{{ route('trx.unpaid') }}" data-toggle="tab" href="#nav-unpaid" role="tab" aria-controls="nav-unpaid" aria-selected="true">Unpaid</a>
                                        <a class="nav-item nav-link" id="nav-paid-tab" data-url="{{ route('trx.paid') }}" data-toggle="tab" href="#nav-paid" role="tab" aria-controls="nav-paid" aria-selected="false">Paid</a>
                                    </div>
                                </nav>
                            </div>
                        </div>

                        <div class="row mt-2 form-unpaid">
                            <div class="col-md-4">
                                <div class="input-group mb-1">
                                <input type="text" class="form-control" id="unpaid" placeholder="Type transaction number" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 form-paid" style="display: none">
                            <div class="col-md-4">
                                <div class="input-group mb-1">
                                <input type="text" class="form-control" id="paid" placeholder="Type transaction number" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row no-border mt-1">
                            <div class="col-md-12">
                                <div class="tab-content mt-2" id="nav-tabContent">
                                    <div class="c-nav-load mt-5">
                                        <i class="fa fa-spin fa-spinner"></i>
                                    </div>
                                    
                                    <div class="tab-pane fade show active" id="nav-unpaid" role="tabpanel" aria-labelledby="nav-unpaid-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="nav-paid" role="tabpanel" aria-labelledby="nav-paid-tab">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="trxDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="trxDetails-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function trxDetails(id) {
            $('#trxDetails-body').html(null);
            $('#trxDetails').modal();
            $('.c-preloader').show();
            $.post('{{ route('show.transaction.details') }}', {_token:'{{ csrf_token() }}', trx_id:id}, function(data){
                $('.c-preloader').hide();
                $('#trxDetails-body').html(data);
            });
        }
        $('#nav-unpaid').load('{{ route('trx.unpaid') }}',function(result){
            $(this).tab('show');
            $('.c-nav-load').hide();
        });

        $('#nav-tab a').click(function (e) {
            e.preventDefault();
            var url = $(this).attr("data-url");
            var href = this.hash;
            if (href == '#nav-unpaid') {
                $('.form-unpaid').show();
                $('.form-paid').hide();
            }else if (href == '#nav-paid') {
                $('.form-paid').show();
                $('.form-unpaid').hide();
            }
            var pane = $(this);
            // ajax load from data-url
            $('.c-nav-load').show();
            $(href).load(url,function(result){
                pane.tab('show');
                $('.c-nav-load').hide();
            });
        });

        $('#unpaid').on('keyup', function(e) {
            $('.c-nav-load').show();
            $.post('{{ route('find.trx.unpaid') }}', {_token:'{{ csrf_token() }}', value:this.value}, function(data){
                $('.c-nav-load').hide();
                $('#nav-unpaid').html(data);
            });
        })

        $('#paid').on('keyup', function(e) {
            $('.c-nav-load').show();
            $.post('{{ route('find.trx.paid') }}', {_token:'{{ csrf_token() }}', value:this.value}, function(data){
                $('.c-nav-load').hide();
                $('#nav-paid').html(data);
            });
        })
    </script>
@endsection
