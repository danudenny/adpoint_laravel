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
                                    {{__('Upload Bukti Tayang')}}
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <div class="float-md-right">
                                    <ul class="breadcrumb">
                                        <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                        <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                        <li><a href="{{ route('broadcast_proof.index') }}">{{__('Broadcast Proof')}}</a></li>
                                        <li class="active"><a href="{{ route('bukti.tayang', encrypt($order_id)) }}">{{__('Broadcast Details')}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <!-- Order history table -->
                    <div class="card no-border mt-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span id="data" hidden>{{ json_encode($query) }}</span>
                                    @foreach ($query as $key => $bukti)
                                        <div class="accordion">
                                            <div class="card">
                                                <div class="card-header bg-default" id="headin{{ $key }}">
                                                    <strong class="mb-0">
                                                        @php
                                                            $orderDetail = \App\OrderDetail::where(['id' => $bukti->od_id, 'status_tayang' => 1])->first();   
                                                        @endphp
                                                        @if ($orderDetail != null)
                                                            @if ($orderDetail->status_tayang == 1)
                                                                <a class="btn btn-info text-white" data-toggle="collapse" data-target="#collapseActive{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                                                    {{ $bukti->name }}
                                                                </a>
                                                                <span class="pull-right">
                                                                    <img src="{{ url('img/label/activated.png') }}" alt="" width="65">
                                                                </span>
                                                            @endif
                                                        @else
                                                        <a class="btn btn-info text-white" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                                        {{ $bukti->name }}
                                                        </a> 
                                                        <span class="pull-right">
                                                            <img src="{{ url('img/label/not_activated.png') }}" alt="" width="65">
                                                        </span>
                                                        @endif
                                                        
                                                    </strong>
                                                </div>
                                                
                                                <div id="collapseActive{{ $key }}" class="collapse" aria-labelledby="headingActive{{ $key }}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                @php
                                                                    $evidencesDone = \App\Evidence::where('order_detail_id',$bukti->od_id)->first();
                                                                @endphp
                                                                <form action="{{ route('upload.bukti.tayang') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="order_detail_id" value="{{ $bukti->od_id }}">
                                                                    @if ($evidencesDone != null)
                                                                        @if ($evidencesDone->status == 1)
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <table class="details-table table">
                                                                                        <tr>
                                                                                            <td class="w-10 strong-600">{{__('No Bukti Tayang')}}</td>
                                                                                            <td>: {{ $evidencesDone->no_bukti }}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td class="w-10 strong-600">{{__('No Order')}}</td>
                                                                                            <td>: {{ $evidencesDone->no_order}}</td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    @php
                                                                                        $file = json_decode($evidencesDone->file);
                                                                                    @endphp
                                                                                    <label><h5>File Gambar</h5></label>
                                                                                    @if ($file->gambar != null)
                                                                                        <div>
                                                                                            @foreach ($file->gambar as $key => $gambar)
                                                                                                <img src="{{ url($gambar->filename) }}" id="img{{ $key }}" class="img-fluid img-thumbnail" width="200" alt="">
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <hr>
                                                                                    @else 
                                                                                        <div>
                                                                                            <strong>Tidak ada</strong>
                                                                                        </div>
                                                                                        <hr>
                                                                                    @endif
                                                                                    
                                                                                    <label class="mt-2"><h5>File Video</h5></label>
                                                                                    @if ($file->video != null)
                                                                                        <div>
                                                                                            @foreach ($file->video as $key => $video)
                                                                                                <img src="{{ url($video->filename) }}" id="img{{ $key }}" class="img-fluid img-thumbnail" width="200" alt="">
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <hr>
                                                                                    @else 
                                                                                        <div>
                                                                                            <strong>Tidak ada</strong>
                                                                                        </div>
                                                                                        <hr>
                                                                                    @endif

                                                                                    <label class="mt-2"><h5>File Zip</h5></label>
                                                                                    @if ($file->zip != null)
                                                                                        <div>
                                                                                            @foreach ($file->zip as $key => $zip)
                                                                                                <img src="{{ url($zip->filename) }}" id="img{{ $key }}" class="img-fluid img-thumbnail" width="200" alt="">
                                                                                            @endforeach
                                                                                        </div>
                                                                                        <hr>
                                                                                    @else 
                                                                                        <div>
                                                                                            <strong>Tidak ada</strong>
                                                                                        </div>
                                                                                        <hr>
                                                                                    @endif
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        @endif
                                                                    @endif
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <form action="{{ route('upload.bukti.tayang') }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <input type="hidden" name="order_detail_id" value="{{ $bukti->od_id }}">
                                                                    <div class="form-group">
                                                                        <label>No Bukti Tayang</label>
                                                                        <input type="hidden" name="order_id" value="{{ $order_id }}">
                                                                        <input type="text" value="{{ $order_id }}-{{ strtotime(date('Ymd'))+$key }}" name="no_bukti" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>No Order</label>
                                                                        <input type="text" value="{{ $bukti->code }}" name="no_order" class="form-control" readonly>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Type File</label>
                                                                        <select class="js-example-basic-multiple" id="type-file{{ $key }}" multiple="multiple">
                                                                            <option value="gambar">Gambar</option>
                                                                            <option value="video">Video</option>
                                                                            <option value="zip">Zip</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <table class="table table-bordered table-sm text-white">
                                                                            <thead class="bg-info">
                                                                                <tr>
                                                                                    <td class="text-center">
                                                                                        Type File
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        Upload File
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        Created at
                                                                                    </td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="body-type-file{{ $key }}">
                                                                                
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <button type="submit" class="btn btn-info">Submit Data</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
@endsection

@section('script')
    <script>
        function capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }

        var order = JSON.parse($('#data').text());

        $.each(order, function(i, result){
            $('#type-file'+i).select2({
                placeholder: 'Gambar / Video / Zip',
            });
            // selecting
            $('#type-file'+i).on('select2:selecting', function(e){
                var selected = e.params.args.data.id; 
                date = new Date();
                     
                var row = `<tr id="row_`+selected+i+`">
                            <td><label>`+ capitalize(selected) +`</label></td>
                            <td><input type="file" name="file`+selected+`[]" class="form-control"></td>
                            <td><input type="text" name="desc`+selected+`[]" value="`+date.toDateString()+`" class="form-control"></td>
                            <td><span id="addfile_`+selected+i+`" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></span></td>
                        </tr>`;
                $('#body-type-file'+i).append(row);

                $('#addfile_'+selected+i).on('click', function(){
                    var id_row = '#row_'+selected+i;
                    $(id_row+' td:nth-child(2)').append(`<input type="file" name="file`+selected+`[]" class="form-control mt-2">`);
                    $(id_row+' td:nth-child(3)').append(`<input type="text" name="desc`+selected+`[]" value="`+date.toDateString()+`" class="form-control mt-2">`);
                })
            })

            // unselecting
            $('#type-file'+i).on('select2:unselecting', function(e){
                var unselected = e.params.args.data.id;
                var id_row = '#row_'+unselected+i;
                $(id_row).remove();
            })
        })
        
        

        
    </script>
@endsection


