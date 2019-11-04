@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{ route('subcategories.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Subcategory')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Subcategories')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Category')}}</th>
                    <th>{{__('Subcategory')}}</th>
                    <th>{{__('Brands')}}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subcategories as $key => $subcategory)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$subcategory->category->name}}</td>
                        <td>{{__($subcategory->name)}}</td>
                        <td>
                            @foreach(json_decode($subcategory->brands) as $brand_id)
                                @if (\App\Brand::find($brand_id) != null)
                                    <span class="badge badge-info">{{\App\Brand::find($brand_id)->name}}</span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li><a href="{{route('subcategories.edit', encrypt($subcategory->id))}}">{{__('Edit')}}</a></li>
                                    <li><a onclick="confirm_modal('{{route('subcategories.destroy', $subcategory->id)}}');">{{__('Delete')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
