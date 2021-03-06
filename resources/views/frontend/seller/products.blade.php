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
                                        {{__('Products')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('seller.products') }}">{{__('Products')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <a class="dashboard-widget text-center plus-widget mt-4 d-block" href="{{ route('seller.products.upload')}}">
                                    <i class="la la-plus"></i>
                                    <span class="d-block title heading-6 strong-400 c-base-1">{{ __('Add New Product') }}</span>
                                </a>
                            </div>
                        </div>

                        <div class="card no-border mt-1">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered table-sm" id="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{__('Name')}}</th>
                                                    <th>{{__('Category')}}</th>
                                                    <th>{{__('Base Price (Rp)')}}</th>
                                                    <th>{{__('Published')}}</th>
                                                    <th>{{__('Featured')}}</th>
                                                    <th>{{__('Options')}}</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($products as $key => $product)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td><a href="{{ route('product', $product->slug) }}" target="_blank">{{ __($product->name) }}</a></td>
                                                        <td>{{ $product->category->name }}</td>
                                                        <td style="text-align: right">{{ number_format($product->unit_price) }}</td>
                                                        <td style="text-align: center">
                                                            @if ($product->published == 0)
                                                                <span class="badge badge-warning" ><i class="fa fa-clock-o"></i> Waiting Approval</span>
                                                            @else
                                                                <label class="switch">
                                                                <input onchange="update_published(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->published == 1) echo "checked";?> >
                                                                <span class="slider round"></span></label>
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center">
                                                            @if ($product->published == 0)
                                                                <span class="badge badge-warning" ><i class="fa fa-clock-o"></i> Waiting Approval</span>
                                                            @else
                                                                <label class="switch">
                                                                <input onchange="update_featured(this)" value="{{ $product->id }}" type="checkbox" <?php if($product->featured == 1) echo "checked";?> >
                                                                <span class="slider round"></span></label>
                                                            @endif
                                                        </td>
                                                        <td style="text-align: center">
                                                            <div class="dropdown">
                                                                <button class="btn" type="button" id="dropdownMenuButton-{{ $key }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-ellipsis-v"></i>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton-{{ $key }}">
                                                                    <a href="{{route('seller.products.edit', encrypt($product->id))}}" class="dropdown-item">{{__('Edit')}}</a>
                                                                    <button onclick="confirm_modal('{{route('products.destroy', $product->id)}}')" class="dropdown-item">{{__('Delete')}}</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
        function update_featured(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showFrontendAlert('success', 'Featured products updated successfully');
                }
                else{
                    showFrontendAlert('danger', 'Something went wrong');
                }
            });
        }

        function update_published(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    showFrontendAlert('success', 'Published products updated successfully');
                }
                else{
                    showFrontendAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection
