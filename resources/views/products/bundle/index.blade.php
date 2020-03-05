@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('products.bundle.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Media Bundles')}}</a>
        </div>
    </div>
    <br>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">{{__('Media Bundles')}}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Bundle Name')}}</th>
                    <th>{{__('List Products')}}</th>
                    <th>{{__('Price')}}</th>
                    <th>{{__('Active')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bundles as $key => $bundle)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$bundle->name}}</td>
                        <td>
                            <div class="row">
                            @foreach(json_decode($bundle->products) as $product_id)
                                @if (\App\Product::find($product_id) != null)
                                    <div class="col-md-6">
                                        @php
                                            $userID = \App\Product::find($product_id)->user_id;
                                        @endphp
                                        <div style="border-radius: 3px; border: 1px solid #ccc; padding: 3px; margin-top:5px;">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <img src="{{ url(\App\User::find($userID)->avatar_original) }}" width="60">
                                                </div>
                                                <div class="col-md-9">
                                                    <b>{{\App\Product::find($product_id)->name}}</b> <br>
                                                    {{single_price(\App\Product::find($product_id)->unit_price)}} <br>
                                                    <i class="text-warning">{{\App\User::find($userID)->name}}</i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        </td>
                        <td>{{single_price($bundle->total_price)}}</td>
                        <td><label class="switch">
                                <input onchange="update_activated(this)" value="{{ $bundle->id }}" type="checkbox" <?php if($bundle->is_active == 1) echo "checked";?> >
                                <span class="slider round"></span></label></td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('bundle.edit', encrypt($bundle->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('subcategories.destroy', $bundle->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>

@endsection
        @section('script')
            <script type="text/javascript">

                $(document).ready(function(){
                    //$('#container').removeClass('mainnav-lg').addClass('mainnav-sm');
                });

                function update_activated(el){
                    if(el.checked){
                        var status = 1;
                    }
                    else{
                        var status = 0;
                    }
                    {{--$.post('{{ route('bundle.updateActive') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){--}}
                    {{--    if(data == 1){--}}
                    {{--        console.log(data);--}}
                    {{--        showAlert('success', 'Activate bundle updated successfully');--}}
                    {{--    }--}}
                    {{--    else{--}}
                    {{--        showAlert('danger', 'Something went wrong');--}}
                    {{--    }--}}
                    {{--});--}}
                }

            </script>
@endsection
