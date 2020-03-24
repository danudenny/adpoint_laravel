@extends('frontend.layouts.app')

@section('content')
    @php
        $trxUnpaid = trx_notif(0, Auth::user()->id)->count();
        $trxPaid = trx_notif(1, Auth::user()->id)->count();
    @endphp
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
                                        <a class="nav-item nav-link" id="nav-unpaid-tab" data-url="{{ route('trx.unpaid') }}" data-toggle="tab" href="#nav-unpaid" role="tab" aria-controls="nav-unpaid" aria-selected="true">
                                            Unpaid
                                            @if ($trxUnpaid > 0)
                                                <b>({{ $trxUnpaid }})</b>
                                            @endif
                                        </a>
                                        <a class="nav-item nav-link" id="nav-paid-tab" data-url="{{ route('trx.paid') }}" data-toggle="tab" href="#nav-paid" role="tab" aria-controls="nav-paid" aria-selected="false">
                                            Paid
                                            @if ($trxPaid > 0)
                                                <b>({{ $trxPaid }})</b>
                                            @endif
                                        </a>
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
                                    <div class="c-nav-load">
                                        <div class="ph-item border-0 p-0 mt-3">
                                            <div class="ph-col-12">
                                                <div class="ph-row">
                                                    <div class="ph-col-12 big"></div>
                                                    <div class="ph-col-12 big"></div>
                                                    <div class="ph-col-12 big"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane fade" id="nav-unpaid" role="tabpanel" aria-labelledby="nav-unpaid-tab">
                                        
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

        $('#nav-tab a').click(function (e) {
            e.preventDefault();
            var url = $(this).attr("data-url");
            var href = this.hash;
            localStorage.setItem('activeTabTrx', $(e.target).attr('href'));
            localStorage.setItem('routeTabTrx', $(e.target).attr('data-url'));

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

        var activeTab = localStorage.getItem('activeTabTrx');
        if(activeTab !== null){
            var routeTab = localStorage.getItem('routeTabTrx')
            $('a[href="'+activeTab+'"]').addClass('active');
            $(activeTab).load(routeTab,function(result){
                $(activeTab).addClass('show');
                $(activeTab).addClass('active');
                $('.c-nav-load').hide();
            });
        }else {
            $('a[href="#nav-unpaid"]').addClass('active');
            $('#nav-unpaid').load('{{ route('trx.unpaid') }}',function(result){
                $('#nav-unpaid').addClass('show');
                $('#nav-unpaid').addClass('active');
                $('.c-nav-load').hide();
            });
        }

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
