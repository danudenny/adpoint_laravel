@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Media Bundles Create')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('Bundle Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Bundle Name')}}" id="name" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('Products')}}</label>
                        <div class="col-sm-9">
                            <select name="products[]" id="products" class="form-control demo-select2" multiple="multiple" required data-placeholder="Choose Products">
                                @foreach($products as $prod)
                                    <option value="{{$prod->id}}">{{$prod->name}} ( {{single_price($prod->unit_price)}} )</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{__('Total Price')}}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="meta_title" placeholder="{{__('Total Price')}}" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{__('Description')}}</label>
                        <div class="col-sm-9">
                            <textarea name="meta_description"  class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-purple" type="submit">{{__('Save')}}</button>
                </div>
            </form>
            <!--===================================================-->
            <!--End Horizontal Form-->

        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Product Bundle List')}}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>{{__('Product Name')}}</th>
                        <th>{{__('Seller')}}</th>
                        <th>{{__('Category')}}</th>
                        <th>{{__('Price')}}</th>
                        <th width="10%">{{__('Options')}}</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        alert($("#products").val())
    </script>
@endsection
