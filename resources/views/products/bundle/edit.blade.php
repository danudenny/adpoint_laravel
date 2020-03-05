@extends('layouts.app')

@section('content')

    <div class="col-lg-6 col-lg-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Media Bundles Edit')}}</h3>
            </div>

            <!--Horizontal Form-->
            <!--===================================================-->
            <form class="form-horizontal" action="{{ route('bundle.update', $bundle->id) }}" method="POST" enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PATCH">
                @csrf
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('Bundle Name')}}</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="{{__('Bundle Name')}}" id="name" name="name" class="form-control" value="{{$bundle->name}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="name">{{__('Products')}}</label>
                        <div class="col-sm-9">
                            <select name="products[]" id="products" class="form-control demo-select2" multiple="multiple" required data-placeholder="Choose Products">
                                @foreach($products as $prod)
                                    <option value="{{$prod->id}}" <?php if(in_array($prod->id, json_decode($bundle->products))) echo "selected";?> >{{$prod->name}} ( {{single_price($prod->unit_price)}} )</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">{{__('Description')}}</label>
                        <div class="col-sm-9">
                            <textarea name="description"  class="form-control">{{$bundle->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer text-right">
                    <button class="btn btn-success" type="submit">{{__('Update')}}</button>
                    <a href="javascript:;" data-toggle="modal" onclick="updateData()"
                       data-target="#UpdateModal" class="btn btn-warning">{{__('Cancel')}}</a>
                </div>
            </form>
{{--            href="{{ route('products.bundle.index')}}"--}}
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

    <div id="UpdateModal" class="modal fade text-warning" role="dialog">
        <div class="modal-dialog ">
            <!-- Modal content-->
            <form action="" id="updateForm" method="post">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title text-center">CANCEL CONFIRMATION</h4>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <p class="text-center">Are You Sure Want To Cancel? ?</p>
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-success" data-dismiss="modal">No, Keep Editing</button>
                            <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Yes, Cancel</button>
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $( "#products" ).change(function() {
            $( "#products" ).each(function() {
               $item = $(this).val();
               console.log($item);
            })
        });

        function updateData()
        {
            var url = '{{ route("products.bundle.index") }}';
            $("#updateForm").attr('action', url);
        }

        function formSubmit()
        {
            $("#updateForm").submit();
        }
    </script>
@endsection
