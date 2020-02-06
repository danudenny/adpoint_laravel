@extends('frontend.layouts.app')

@section('content')

    <section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @include('frontend.inc.seller_side_nav')
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0">
                                        {{__('Orders')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li class="active"><a href="{{ route('orders.index') }}">{{__('Orders')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order history table -->
                        
                        <div class="row no-border mt-4">
                            <div class="col-md-10">
                                <div class="form-group">
                                    <div id="reportrange" style="background: #fff; cursor: pointer; padding: 8px; border: 1px solid #ccc; width: 100%; border-radius: 3px;">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <input type="hidden" name="date_start" id="date_start" value="">
                                <input type="hidden" name="date_end" id="date_end" value="">
                                <input type="hidden" name="status" id="status" value="">
                                <div class="form-group">
                                    <button onclick="findOrders()" class="btn btn-block btn-outline-info">Apply</button>
                                </div>
                            </div>
                        </div>

                        <div class="row no-border mt-2">
                            <div class="col-md-12">
                                <nav class="no-border" style="color: black">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-order-place-tab" data-url="{{ route('orders.place.order') }}" data-toggle="tab" href="#nav-order-place" role="tab" aria-controls="nav-order-place" aria-selected="true">Order place</a>
                                        <a class="nav-item nav-link" id="nav-onreview-tab" data-url="{{ route('orders.review.order') }}" data-toggle="tab" href="#nav-onreview" role="tab" aria-controls="nav-onreview" aria-selected="false">On review</a>
                                        <a class="nav-item nav-link" id="nav-active-tab" data-url="{{ route('orders.active.order') }}" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="false">Active</a>
                                        <a class="nav-item nav-link" id="nav-complete-tab" data-url="{{ route('orders.complete.order') }}" data-toggle="tab" href="#nav-complete" role="tab" aria-controls="nav-complete" aria-selected="false">Complete</a>
                                        <a class="nav-item nav-link" id="nav-cancel-tab" data-url="{{ route('orders.cancelled.order') }}" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-cancel" aria-selected="false">Cancelled</a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        
                        <div class="row no-border mt-1">
                            <div class="col-md-12">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="c-nav-load mt-5">
                                        <i class="fa fa-spin fa-spinner"></i>
                                    </div>
                                    <div class="tab-pane fade show active" id="nav-order-place" role="tabpanel" aria-labelledby="nav-order-place-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="nav-onreview" role="tabpanel" aria-labelledby="nav-onreview-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="nav-complete" role="tabpanel" aria-labelledby="nav-complete-tab">
                                        
                                    </div>
                                    <div class="tab-pane fade" id="nav-cancel" role="tabpanel" aria-labelledby="nav-cancel-tab">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="buktiTayang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" id="modal-size" role="document">
            <div class="modal-content">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="buktiTayang_body">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="itemDetailsSeller" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="c-preloader">
                    <i class="fa fa-spin fa-spinner"></i>
                </div>
                <div id="itemDetailsSellerbody">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function buktiTayang(id) {
            $('#buktiTayang_body').html(null);
            $('#buktiTayang').modal();
            $('.c-preloader').show();
            $.post('{{ route('bukti.tayang.detail') }}', {_token:'{{ csrf_token() }}', order_detail_id:id}, function(data){
                $('.c-preloader').hide();
                $('#buktiTayang_body').html(data);
            });
        }

        function itemDetailsSeller(id) {
            $('#itemDetailsSellerbody').html(null);
            $('#itemDetailsSeller').modal();
            $('.c-preloader').show();
            $.post('{{ route('item.details.seller') }}', {_token:'{{ csrf_token() }}', order_detail_id:id}, function(data){
                $('.c-preloader').hide();
                $('#itemDetailsSellerbody').html(data);
            });
        }

        $('#nav-order-place').load('{{ route('orders.place.order') }}',function(result){
            $(this).tab('show');
            $('.c-nav-load').hide();
        });

        $('#status').val(0);
        $('#nav-tab a').click(function (e) {
            e.preventDefault();
            var url = $(this).attr("data-url");
            var href = this.hash;
            var pane = $(this);

            switch (href) {
                case '#nav-order-place':
                    $('#status').val(0);
                    break;
                case '#nav-onreview':
                    $('#status').val(1);
                    break;
                case '#nav-active':
                    $('#status').val(3);
                    break;
                case '#nav-complete':
                    $('#status').val(4);
                    break;
                case '#nav-cancel':
                    $('#status').val(100);
                    break;
                default:
                    break;
            }
            // ajax load from data-url
            $('.c-nav-load').show();
            $(href).load(url,function(result){
                pane.tab('show');
                $('.c-nav-load').hide();
            });
        });

        // date range picker
        var start = moment().subtract(29, 'days');
        var end = moment();
    
        function cb(start, end) {
            $('#reportrange span').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            var val_date_start = start.format('D MMM YYYY HH:mm:ss');
            var val_date_end = end.format('D MMM YYYY HH:mm:ss');
            $('#date_start').val(val_date_start);
            $('#date_end').val(val_date_end);
        }
        
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    
        cb(start, end);

        function findOrders() {
            $('.c-nav-load').show();
            var start = $('#date_start').val();
            var end = $('#date_end').val();
            var status = $('#status').val();

            var data = {
                _token:'{{ csrf_token() }}',
                start : start,
                end : end,
                status : status,
            }
            switch (status) {
                case "0":
                    findOrdersProses(data, '#nav-order-place');
                    break;
                case "1":
                    findOrdersProses(data, '#nav-onreview');
                    break;
                case "3":
                    findOrdersProses(data, '#nav-active');
                    break;
                case "4":
                    findOrdersProses(data, '#nav-complete');
                    break;
                case "100":
                    findOrdersProses(data, '#nav-cancel');
                    break;
                default:
                    break;
            }
        }

        function findOrdersProses(object, attr) {
            $.post('{{ route('find.orders') }}', object, function(data){
                $('.c-nav-load').hide();
                $(attr).html(data);
            });
        }

    </script>
@endsection