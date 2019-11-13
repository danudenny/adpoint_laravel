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
                                        {{__('Add Your Media')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('seller.products') }}">{{__('Products')}}</a></li>
                                            <li class="active"><a href="{{ route('seller.products.upload') }}">{{__('Add New Media')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" id="choice_form">
                            @csrf
                    		<input type="hidden" name="added_by" value="seller">

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('General')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Media Category')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-control mb-3 c-pointer" data-toggle="modal" data-target="#categorySelectModal" id="product_category">{{__('Select a category')}}</div>
                                            <input type="hidden" name="category_id" id="category_id" value="" required>
                                            <input type="hidden" name="subcategory_id" id="subcategory_id" value="" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Media Name')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" id="product_name" class="form-control mb-3" name="name" placeholder="{{__('Product Name')}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Media Partner')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker" data-placeholder="Select a media partner" id="brands" name="brand_id" required>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Media Tag')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3 tagsInput" name="tags[]" placeholder="Type & hit enter" data-role="tagsinput">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Description')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Description')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <textarea class="editor" name="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Termin Pembayaran')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <textarea class="form-control mb-3" name="termin_pembayaran" cols="20" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Images')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div id="product-images">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Main Images')}} <span class="required-star">*</span></label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="file" name="photos[]" id="photos-1" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                <label for="photos-1" class="mw-100 mb-3">
                                                    <span></span>
                                                    <strong>
                                                        <i class="fa fa-upload"></i>
                                                        {{__('Choose image')}}
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info mb-3" onclick="add_more_slider_image()">{{ __('Add More') }}</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Thumbnail Image')}} <small>(290x300)</small> <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="thumbnail_img" id="file-2" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-2" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Featured')}} <small>(290x300)</small></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="featured_img" id="file-3" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-3" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Flash Deal')}} <small>(290x300)</small></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="flash_deal_img" id="file-4" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                            <label for="file-4" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose image')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4" hidden>
                                <div class="form-box-title px-3 py-2">
                                    {{__('Videos')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Video From')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control selectpicker" data-minimum-results-for-search="Infinity" name="video_provider">
                                                    <option value="youtube">{{__('Youtube')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Video URL')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="video_link" placeholder="{{__('Video link')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                    <div class="form-box-title px-3 py-2">
                                        {{__('Meta Tags')}}
                                    </div>
                                    <div class="form-box-content p-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Meta Title')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control mb-3" name="meta_title" placeholder="{{__('Meta Title')}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Description')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea name="meta_description" rows="8" class="form-control mb-3" placeholder="{{__('Meta Description')}}"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <label>{{__('Meta Image')}}</label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="file" name="meta_img" id="file-5" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                <label for="file-5" class="mw-100 mb-3">
                                                    <span></span>
                                                    <strong>
                                                        <i class="fa fa-upload"></i>
                                                        {{__('Choose image')}}
                                                    </strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Periode')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <span>
                                        <i style="color: red">Tambahkan Periode menggunakan kategori periode seperti <b>"Harian, Bulanan, atau Tahunan"</b>. Tekan enter untuk menambah kategori periode.</i>
                                    </span>
                                    <hr>
                                    <div class="row mb-3">
                                        <div class="col-8 col-md-3 order-1 order-md-0">
                                            <input type="hidden" id="choice_options" name="choice_options">
                                            <input type="text" class="form-control" value="Periode" disabled>
                                        </div>
                                        <div class="col-12 col-md-7 col-xl-8 order-3 order-md-0 mt-2 mt-md-0">
                                            <select class="js-example-basic-multiple" name="" id="selectOption" multiple="multiple">
                                                <option value="Harian">Harian</option>
                                                <option value="Bulanan">Bulanan</option>
                                                <option value="EnamBulan">6 Bulan</option>
                                                <option value="Tahunan">Tahunan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Price')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Base Price')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" min="0" step="0.01" name="unit_price" class="form-control mb-3" id="unit_price" placeholder="{{__('Unit Price')}} ({{__('Base Price')}})" required readonly>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Purchase Price')}} </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" min="0" value="0" step="0.01" class="form-control mb-3" name="purchase_price" placeholder="{{__('Purchase Price')}}">
                                        </div>
                                    </div> --}}
                                    {{-- <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Tax (10%)')}}</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" min="0" value="0" step="0.01" class="form-control mb-3" name="tax" placeholder="{{__('Tax')}}" required>
                                        </div>
                                        <div class="col-4 col-md-2">
                                            <div class="mb-3">
                                                <select class="form-control selectpicker" name="tax_type" data-minimum-results-for-search="Infinity">
                                                    <option value="1">Rupiah (Rp)</option>
                                                    <option value="2">Percent (%)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-12" id="sku_combination">
                                            <input type="hidden" name="variations" id="variations">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td class="text-center">
                                                            <label class="control-label">{{__('Variant')}}</label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="control-label">{{__('Variant Price')}}</label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="control-label">{{__('SKU')}}</label>
                                                        </td>
                                                        <td class="text-center">
                                                            <label class="control-label">{{__('Quantity')}}</label>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <tbody id="row_variations">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box bg-white mt-4" hidden>
                                <div class="form-box-title px-3 py-2">
                                    {{__('Shipping')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Local Pickup')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" value="0" class="form-control mb-3" name="local_pickup_shipping_cost" placeholder="{{__('Local Pickup Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="local_pickup" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Flat Rate')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" value="0" class="form-control mb-3" name="flat_shipping_cost" placeholder="{{__('Flat Rate Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="flat_rate" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Free Shipping')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" value="0" class="form-control mb-3" name="free_shipping_cost" value="0" disabled placeholder="{{__('Flat Rate Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="free" checked>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-box bg-white mt-4" >
                                <div class="form-box-title px-3 py-2">
                                    {{__('Lokasi')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div id="addProductMap" class="map mb-3"></div>
                                    <input type="hidden" class="form-control mb-3" name="latlong" id="latlong">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Alamat')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="alamat" class="form-control mb-3" id="alamat" cols="20" rows="5" autocomplete="off"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Provinsi')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select name="provinsi" id="prov" class="form-control mb-3">
                                                <option selected disabled>--- SELECT PROVINSI ---</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Kota / Kabupaten')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select name="kota" id="kab" class="form-control mb-3">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Kecamatan')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <select name="kecamatan" id="kec" class="form-control mb-3">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Demografi Wilayah')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Audien Target')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="audien_target" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Statistik / Keadaan Masyarakat')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="statistik_masyarakat" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Jumlah Audien / Kendaraan / Pendengar (Radio)')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="jumlah_pendengarradio" >
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Target Audien / Pendengar (Radio)')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="target_pendengarradio" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('PDF Specification')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('PDF')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="file" name="pdf" id="file-6" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="pdf/*" />
                                            <label for="file-6" class="mw-100 mb-3">
                                                <span></span>
                                                <strong>
                                                    <i class="fa fa-upload"></i>
                                                    {{__('Choose PDF')}}
                                                </strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-box mt-4 text-right">
                                <button type="submit" class="btn btn-styled btn-base-1">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="categorySelectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Select Category</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="target-category heading-6">
                        <span class="mr-3">{{__('Target Category')}}:</span>
                        {{-- <span>{{__('category')}} > {{__('subcategory')}} > {{__('subsubcategory')}}</span> --}}
                        <span>{{__('category')}} > {{__('subcategory')}}</span>
                    </div>
                    <div class="row no-gutters modal-categories mt-4 mb-2">
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="Search Category" onkeyup="filterListItems(this, 'categories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list has-right-arrow">
                                    <ul id="categories">
                                        @foreach ($categories as $key => $category)
                                            <li onclick="get_subcategories_by_category(this, {{ $category->id }})">{{ __($category->name) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="modal-category-box c-scrollbar" id="subcategory_list">
                                <div class="sort-by-box">
                                    <form role="form" class="search-widget">
                                        <input class="form-control input-lg" type="text" placeholder="Search SubCategory" onkeyup="filterListItems(this, 'subcategories')">
                                        <button type="button" class="btn-inner">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="modal-category-list has-right-arrow">
                                    <ul id="subcategories">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('cancel')}}</button>
                    <button type="button" class="btn btn-primary" onclick="closeModal()">{{__('Confirm')}}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">

        var category_name = "";
        var subcategory_name = "";

        var category_id = null;
        var subcategory_id = null;

        $(document).ready(function(){
            $('#subcategory_list').hide();
        });

        function list_item_highlight(el){
            $(el).parent().children().each(function(){
                $(this).removeClass('selected');
            });
            $(el).addClass('selected');
        }

        function get_subcategories_by_category(el, cat_id){
            list_item_highlight(el);
            category_id = cat_id;
            subcategory_id = null;
            category_name = $(el).html();
            $('#subcategories').html(null);
            $.post('{{ route('subcategories.get_subcategories_by_category') }}',{_token:'{{ csrf_token() }}', category_id:category_id}, function(data){
                for (var i = 0; i < data.length; i++) {
                    $('#subcategories').append('<li onclick="confirm_subcategory(this, '+data[i].id+')">'+data[i].name+'</li>');
                }
                $('#subcategory_list').show();
            });
        }

        function confirm_subcategory(el, subcat_id){
            list_item_highlight(el);
            subcategory_id = subcat_id;
            subcategory_name = $(el).html();
    	}

        function get_brands_by_subcategory(subcat_id){
            $('#brands').html(null);
    		$.post('{{ route('subcategories.get_brands_by_subcategory') }}',{_token:'{{ csrf_token() }}', subcategory_id:subcategory_id}, function(data){
    		    for (var i = 0; i < data.length; i++) {
    		        $('#brands').append($('<option>', {
    		            value: data[i].id,
    		            text: data[i].name
    		        }));
    		    }
    		});
    	}

        function filterListItems(el, list){
            filter = el.value.toUpperCase();
            li = $('#'+list).children();
            for (i = 0; i < li.length; i++) {
                if ($(li[i]).html().toUpperCase().indexOf(filter) > -1) {
                    $(li[i]).show();
                } else {
                    $(li[i]).hide();
                }
            }
        }

        function closeModal(){
            if(category_id > 0 && subcategory_id > 0 ){
                $('#category_id').val(category_id);
                $('#subcategory_id').val(subcategory_id);
                $('#product_category').html(category_name+'>'+subcategory_name);
                $('#categorySelectModal').modal('hide');
                get_brands_by_subcategory(subcategory_id);
            }
            else{
                alert('Please choose categories...');
                console.log(category_id);
                console.log(subcategory_id);
                //showAlert();
            }
        }

        // dropdown choice options and variation
        $('.js-example-basic-multiple').select2({
            placeholder: 'Harian / Bulanan / Enam Bulan / Tahunan',
        });

        var choice_options = [{title : 'Periode',options: []}];
        var variations = {};
        $('.js-example-basic-multiple').on('select2:selecting', function(e){
            var selected = e.params.args.data.id;
            var product_name = $('#product_name').val();
            var sku_awal = product_name.split(' ');
            var sku_akhir;
            if (sku_awal.length === 1) {
                sku_akhir = ''; 
            }else{
                sku_akhir = sku_awal[0][0] + sku_awal[1][0];
            }
            var row = `<tr id="id_`+selected+`">
                        <td><label class="control-label">`+selected+`</label></td>
                        <td><input type="number" name="var_price" id="var_price_`+selected+`" min="0" step="0.01" class="form-control"></td>
                        <td><input type="text" id="var_sku_`+selected+`" value="`+ sku_akhir + '-' + selected +`" class="form-control"></td>
                        <td><input type="number" id="var_qty_`+selected+`" value="10" min="0" step="1" class="form-control"></td>
                       </tr>`;
            $('#unit_price').prop('readonly', false);
            $('#row_variations').append(row);
            choice_options[0].options.push(selected);
            variations[selected] = {};
            variations[selected]['price'] = "";
            variations[selected]['sku'] = sku_akhir+'-'+selected;
            variations[selected]['qty'] = "10";
            $('#choice_options').attr('value', JSON.stringify(choice_options));
            $('#variations').attr('value', JSON.stringify(variations));
            
            function changeVariations(prop){
                $('#var_price_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].price = value;
                    $('#variations').attr('value', JSON.stringify(variations));
                });
                $('#var_sku_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].sku = value;
                    $('#variations').attr('value', JSON.stringify(variations));
                });
                $('#var_qty_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].qty = value;
                    $('#variations').attr('value', JSON.stringify(variations));
                });
            }

            if(selected === 'Harian'){
                changeVariations(selected);
            }else if(selected === 'Bulanan'){
                changeVariations(selected);
            }else if(selected === 'EnamBulan'){
                changeVariations(selected);
            }else if(selected === 'Tahunan'){
                changeVariations(selected);
            }
        });

        $('.js-example-basic-multiple').on('select2:unselecting', function(e){
            var unselected = e.params.args.data.id;
            var id_row = '#id_'+unselected;
            if(unselected === 'Harian'){
                if(e.params.args.data.selected === true){
                    $('#unit_price').prop('readonly', true);
                }
            }
            $(id_row).remove();

            Array.prototype.remove = function() {
                var what, a = arguments, L = a.length, ax;
                while (L && this.length) {
                    what = a[--L];
                    while ((ax = this.indexOf(what)) !== -1) {
                        this.splice(ax, 1);
                    }
                }
                return this;
            };

            switch (unselected) {
                case 'Harian':
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                case 'Bulanan':
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                case 'EnamBulan':
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                case 'Tahunan':
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                default:
                    break;
            }

            function deleteChoice(prop){
                choice_options[0].options.remove(prop);
                $('#choice_options').attr('value', JSON.stringify(choice_options));
            }

            function deleteVariations(prop) {
                delete variations[prop];
                $('#variations').attr('value', JSON.stringify(variations));
            }
            
        })

        // disable scrool input number
        $('form').on('focus', 'input[type=number]', function (e) {
            $(this).on('wheel.disableScroll', function (e) {
                e.preventDefault()
            })
        })
        $('form').on('blur', 'input[type=number]', function (e) {
            $(this).off('wheel.disableScroll')
        })
        // end dropdown choice option and variation


        var photo_id = 2;
        function add_more_slider_image(){
            var photoAdd =  '<div class="row">';
            photoAdd +=  '<div class="col-2">';
            photoAdd +=  '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            photoAdd +=  '</div>';
            photoAdd +=  '<div class="col-10">';
            photoAdd +=  '<input type="file" name="photos[]" id="photos-'+photo_id+'" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />';
            photoAdd +=  '<label for="photos-'+photo_id+'" class="mw-100 mb-3">';
            photoAdd +=  '<span></span>';
            photoAdd +=  '<strong>';
            photoAdd +=  '<i class="fa fa-upload"></i>';
            photoAdd +=  "{{__('Choose image')}}";
            photoAdd +=  '</strong>';
            photoAdd +=  '</label>';
            photoAdd +=  '</div>';
            photoAdd +=  '</div>';
            $('#product-images').append(photoAdd);

            photo_id++;
            imageInputInitialize();
        }
        function delete_this_row(em){
            $(em).closest('.row').remove();
        }

    </script>
@endsection
