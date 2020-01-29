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
                        
                        <div class="card no-border mt-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="startDate" placeholder="Start">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="endDate" placeholder="End">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control selectpicker">
                                            <option value="latest">Latest</option>
                                            <option value="old">Old</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button class="btn btn-danger">Reset Filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card no-border mt-2">
                            <div class="card-body">
                                <nav class="no-border" style="color: black">
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-order-place-tab" data-toggle="tab" href="#nav-order-place" role="tab" aria-controls="nav-order-place" aria-selected="true">Order place</a>
                                    <a class="nav-item nav-link" id="nav-onreview-tab" data-toggle="tab" href="#nav-onreview" role="tab" aria-controls="nav-onreview" aria-selected="false">On review</a>
                                    <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="false">Active</a>
                                    <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete" role="tab" aria-controls="nav-complete" aria-selected="false">Complete</a>
                                    <a class="nav-item nav-link" id="nav-cancel-tab" data-toggle="tab" href="#nav-cancel" role="tab" aria-controls="nav-cancel" aria-selected="false">Cancelled</a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                        
                        <div class="card no-border mt-1">
                            <div class="card-body">
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-order-place" role="tabpanel" aria-labelledby="nav-order-place-tab">
                                        @foreach ($order_details as $key => $od)
                                            @if ($od->status === 0)
                                                <article class="card mt-1">
                                                    <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                        <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            @php
                                                                $product = \App\Product::where('id', $od->product_id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                </td>
                                                                <td> 
                                                                    {{ $product->name }} <br>
                                                                    {{ $od->variation }} 
                                                                    <small>
                                                                        ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} ) 
                                                                    </small>
                                                                    @php
                                                                        $query = DB::table('transactions as t')
                                                                                    ->join('orders as o', 'o.transaction_id', '=', 't.id')
                                                                                    ->join('order_details as od', 'od.order_id', '=', 'o.id')
                                                                                    ->where([
                                                                                        'od.id' => $od->id,
                                                                                        'o.seller_id' => Auth::user()->id
                                                                                    ])
                                                                                    ->select([
                                                                                        't.payment_status'
                                                                                    ])->first();
                                                                    @endphp
                                                                    @if ($query->payment_status === 1)
                                                                        <div class="badge badge-success">Paid</div>
                                                                    @else 
                                                                        <div class="badge badge-danger">Unpaid</div>
                                                                    @endif
                                                                </td>
                                                                <td align="right">
                                                                    <button data-toggle="modal" data-target="#approve{{$od->id}}" class="btn btn-outline-success btn-circle btn-sm"><i class="fa fa-check"></i> Approve</button>
                                                                    <button data-toggle="modal" data-target="#reject{{$od->id}}" class="btn btn-sm btn-circle btn-outline-danger">
                                                                        <i class="fa fa-times"></i> Reject
                                                                    </button>
                                                                    <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                                                        <i class="fa fa-eye"></i> Details
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </article>
                                                <!-- Modal Approve-->
                                                <div class="modal fade" id="approve{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure approve ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>#{{ \App\Product::where('id', $od->product_id)->first()->name }}</h5>
                                                            <p>Clik yes to continue approve.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <a href="{{ route('approve.by.seller', encrypt($od->id)) }}" class="btn btn-primary">Yes</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>

                                                <!-- Modal Reject -->

                                                <div class="modal fade" id="reject{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <form action="{{ route('disapprove.by.seller') }}" method="POST">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Reject item {{ $product->name }}</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        @csrf
                                                                        <input type="hidden" name="od_id" value="{{$od->id}}">
                                                                        <label>Alasan</label>
                                                                        <textarea name="alasan" class="form-control" placeholder="Tuliskan alasan" cols="20" rows="5"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="nav-onreview" role="tabpanel" aria-labelledby="nav-onreview-tab">
                                        @foreach ($order_details as $key => $od)
                                            @if ($od->status === 1)
                                                <article class="card mt-1">
                                                    <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                        <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            @php
                                                                $product = \App\Product::where('id', $od->product_id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                </td>
                                                                <td> 
                                                                    {{ $product->name }} <br>
                                                                    {{ $od->variation }} 
                                                                    <small>
                                                                        ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                    </small>
                                                                    @php
                                                                        $query = DB::table('transactions as t')
                                                                                    ->join('orders as o', 'o.transaction_id', '=', 't.id')
                                                                                    ->join('order_details as od', 'od.order_id', '=', 'o.id')
                                                                                    ->where([
                                                                                        'od.id' => $od->id,
                                                                                        'o.seller_id' => Auth::user()->id
                                                                                    ])
                                                                                    ->select([
                                                                                        't.payment_status'
                                                                                    ])->first();
                                                                    @endphp
                                                                    @if ($query->payment_status === 1)
                                                                        <div class="badge badge-success">Paid</div>
                                                                    @else 
                                                                        <div class="badge badge-danger">Unpaid</div>
                                                                    @endif
                                                                </td>
                                                                <td align="right">
                                                                    <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                                                        <i class="fa fa-eye"></i> Details
                                                                    </button>
                                                                    @if ($od->status == 1)
                                                                        @if ($od->is_paid == true)
                                                                            <button data-toggle="modal" data-target="#active{{$od->id}}" class="btn btn-circle btn-sm btn-outline-primary">
                                                                                <i class="fa fa-calendar-check-o"></i> Activate
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-sm btn-circle btn-outline-primary" style="cursor: not-allowed" disabled>
                                                                                <i class="fa fa-calendar-check-o"></i> Activate
                                                                            </button>
                                                                        @endif
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </article>

                                                <!-- Modal Approve-->
                                                <div class="modal fade" id="active{{ $od->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure activate ?</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>#{{ \App\Product::where('id', $od->product_id)->first()->name }}</h5>
                                                            <p>Clik yes to continue activate.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <a href="{{ route('order.activate', encrypt($od->id)) }}" class="btn btn-primary">Yes</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
                                        @foreach ($order_details as $key => $od)
                                            @if ($od->status === 3)
                                                <article class="card mt-1">
                                                    <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                        <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            @php
                                                                $product = \App\Product::where('id', $od->product_id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                </td>
                                                                <td width="250"> 
                                                                    {{ $product->name }} <br>
                                                                    {{ $od->variation }} 
                                                                    <small>
                                                                        ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                    </small>
                                                                    @php
                                                                        $query = DB::table('transactions as t')
                                                                                    ->join('orders as o', 'o.transaction_id', '=', 't.id')
                                                                                    ->join('order_details as od', 'od.order_id', '=', 'o.id')
                                                                                    ->where([
                                                                                        'od.id' => $od->id,
                                                                                        'o.seller_id' => Auth::user()->id
                                                                                    ])
                                                                                    ->select([
                                                                                        't.payment_status'
                                                                                    ])->first();
                                                                    @endphp
                                                                    @if ($query->payment_status === 1)
                                                                        <div class="badge badge-success">Paid</div>
                                                                    @else 
                                                                        <div class="badge badge-danger">Unpaid</div>
                                                                    @endif
                                                                </td>
                                                                <td align="right">
                                                                    <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                                                        <i class="fa fa-eye"></i> Details
                                                                    </button>
                                                                    <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="buktiTayang({{ $od->id }})">
                                                                        <i class="fa fa-upload"></i> Bukti Tayang
                                                                    </button> 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </article>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="tab-pane fade" id="nav-complete" role="tabpanel" aria-labelledby="nav-complete-tab">
                                        <h1>Active</h1>
                                    </div>
                                    <div class="tab-pane fade" id="nav-cancel" role="tabpanel" aria-labelledby="nav-cancel-tab">
                                        @foreach ($order_details as $key => $od)
                                            @if ($od->status === 100)
                                                <article class="card mt-1">
                                                    <div style="height: 35px; background: #0f355a; color: white; border-bottom: 2px solid #fd7e14">
                                                        <strong style="line-height: 35px; margin-left: 15px">{{ $od->created_at }}</strong>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            @php
                                                                $product = \App\Product::where('id', $od->product_id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td width="80">
                                                                    <img src="{{ url(json_decode($product->photos)[0]) }}" class="img-fluid" width="50">
                                                                </td>
                                                                <td width="250"> 
                                                                    {{ $product->name }} <br>
                                                                    {{ $od->variation }} 
                                                                    <small>
                                                                        ( {{ date('d M Y', strtotime($od->start_date)) }} - {{ date('d M Y', strtotime($od->end_date)) }} )
                                                                    </small>
                                                                    @php
                                                                        $query = DB::table('transactions as t')
                                                                                    ->join('orders as o', 'o.transaction_id', '=', 't.id')
                                                                                    ->join('order_details as od', 'od.order_id', '=', 'o.id')
                                                                                    ->where([
                                                                                        'od.id' => $od->id,
                                                                                        'o.seller_id' => Auth::user()->id
                                                                                    ])
                                                                                    ->select([
                                                                                        't.payment_status'
                                                                                    ])->first();
                                                                    @endphp
                                                                    @if ($query->payment_status === 1)
                                                                        <div class="badge badge-success">Paid</div>
                                                                    @else 
                                                                        <div class="badge badge-danger">Unpaid</div>
                                                                    @endif
                                                                </td>
                                                                <td width="200">
                                                                    QTY: {{ $od->quantity }} <br>
                                                                    {{ single_price($od->price) }}
                                                                </td>
                                                                <td>
                                                                    Status: 
                                                                    @if ($od->status === 100)
                                                                        <div class="badge badge-danger">
                                                                            Rejected
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td align="right">
                                                                    <button class="btn btn-outline-secondary btn-circle btn-sm" onclick="itemDetailsSeller({{ $od->id }})">
                                                                        <i class="fa fa-eye"></i> Details
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </article>
                                            @endif
                                        @endforeach
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
    </script>
@endsection