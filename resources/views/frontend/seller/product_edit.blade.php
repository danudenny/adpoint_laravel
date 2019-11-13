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
                                        {{__('Update your product')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('seller.products') }}">{{__('Products')}}</a></li>
                                            <li class="active"><a href="{{ route('seller.products.edit', $product->id) }}">{{__('Edit Product')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form class="" action="{{route('products.update', $product->id)}}" method="POST" enctype="multipart/form-data" id="choice_form">
                            <input name="_method" type="hidden" value="POST">
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            @csrf
                    		<input type="hidden" name="added_by" value="seller">

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('General')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Category')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="form-control mb-3 c-pointer" data-toggle="modal" data-target="#categorySelectModal" id="product_category">{{ $product->category->name.'>'.$product->subcategory->name}}</div>
                                            <input type="hidden" name="category_id" id="category_id" value="{{ $product->category_id }}" required>
                                            <input type="hidden" name="subcategory_id" id="subcategory_id" value="{{ $product->subcategory_id }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Name')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" id="product_name" name="name" placeholder="{{__('Product Name')}}" value="{{ __($product->name) }}">
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Brand')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="mb-3">
                                                <select class="form-control mb-3 selectpicker" data-placeholder="Select a brand" id="brands" name="brand_id">
                                                    @foreach (json_decode($product->subcategory->brands) as $key => $brand_id)
                                                        <option value="{{ \App\Brand::find($brand_id)->id }}" <?php if($brand_id == $product->brand_id) echo "selected";?> >{{ \App\Brand::find($brand_id)->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Product Tag')}} </label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3 tagsInput" name="tags[]" placeholder="Type & hit enter" data-role="tagsinput" value="{{ $product->tags }}">
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
                                                <textarea class="editor" name="description">{{$product->description}}</textarea>
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
                                                <textarea class="editor" name="termin_pembayaran">{{$product->termin_pembayaran}}</textarea>
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
                                                <div class="row">
                                                    @foreach (json_decode($product->photos) as $key => $photo)
                                                        <div class="col-md-3">
                                                            <div class="img-upload-preview">
                                                                <img src="{{ asset($photo) }}" alt="" class="img-responsive">
                                                                <input type="hidden" name="previous_photos[]" value="{{ $photo }}">
                                                                <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
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
                                            <div class="row">
                                                @if ($product->thumbnail_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->thumbnail_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_thumbnail_img" value="{{ $product->thumbnail_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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
                                            <div class="row">
                                                @if ($product->featured_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->featured_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_featured_img" value="{{ $product->featured_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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
                                            <div class="row">
                                                @if ($product->flash_deal_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->flash_deal_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_flash_deal_img" value="{{ $product->flash_deal_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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
                                                    <option value="youtube" <?php if($product->video_provider == 'youtube') echo "selected";?> >{{__('Youtube')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Video URL')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control mb-3" name="video_link" placeholder="{{__('Video link')}}" value="{{ $product->video_link }}">
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
                                            <input type="text" class="form-control mb-3" name="meta_title" value="{{ $product->meta_title }}" placeholder="{{__('Meta Title')}}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Description')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="meta_description" rows="8" class="form-control mb-3">{{ $product->meta_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Meta Image')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <div class="row">
                                                @if ($product->meta_img != null)
                                                    <div class="col-md-3">
                                                        <div class="img-upload-preview">
                                                            <img src="{{ asset($product->meta_img) }}" alt="" class="img-responsive">
                                                            <input type="hidden" name="previous_meta_img" value="{{ $product->meta_img }}">
                                                            <button type="button" class="btn btn-danger close-btn remove-files"><i class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
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
                                            <input type="hidden" id="choice_optionsEdit" name="choice_options" value="{{ $product->choice_options }}">
                                            <input type="text" class="form-control" value="Periode" disabled>
                                        </div>
                                       
                                        <div class="col-12 col-md-7 col-xl-8 order-3 order-md-0 mt-2 mt-md-0">
                                            <select class="js-example-basic-multiple" id="selectOptionEdit" multiple>
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
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="unit_price" id="unit_price" placeholder="{{__('Base Price')}} ({{__('Base Price')}})" value="{{$product->unit_price}}">
                                        </div>
                                    </div>
                                    <div class="row" hidden>
                                        <div class="col-md-2">
                                            <label>{{__('Purchase Price')}} <span class="required-star">*</span></label>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="purchase_price" placeholder="{{__('Purchase Price')}}" value="{{$product->purchase_price}}">
                                        </div>
                                    </div>
                                    <div class="row" hidden>
                                        <div class="col-md-2">
                                            <label>{{__('Tax')}}</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="tax" placeholder="{{__('Tax')}}" value="{{$product->tax}}">
                                        </div>
                                        <div class="col-md-2 col-4">
                                            <div class="mb-3">
                                                <select class="form-control selectpicker" name="tax_type" data-minimum-results-for-search="Infinity">
                                                    <option value="amount" <?php if($product->tax_type == 'amount') echo "selected";?> >Rupiah (Rp)</option>
                                                    <option value="percent" <?php if($product->tax_type == 'percent') echo "selected";?> >Percent (%)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" id="sku_combination">
                                            <input type="hidden" name="variations" id="variationsEdit" value="{{ $product->variations }}">
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
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="local_pickup_shipping_cost" value="{{ $product->shipping_cost }}" placeholder="{{__('Local Pickup Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="local_pickup" @if($product->shipping_type == 'local_pickup') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Flat Rate')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="flat_shipping_cost" value="{{ $product->shipping_cost }}" placeholder="{{__('Flat Rate Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="flat_rate" @if($product->shipping_type == 'flat_rate') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Free Shipping')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="number" min="0" step="0.01" class="form-control mb-3" name="free_shipping_cost" value="0" disabled placeholder="{{__('Flat Rate Cost')}}">
                                        </div>
                                        <div class="col-md-2">
                                            <label class="switch" style="margin-top:5px;">
                                                <input type="radio" name="shipping_type" value="free" @if($product->shipping_type == 'free') checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-box bg-white mt-4">
                                <div class="form-box-title px-3 py-2">
                                    {{__('Lokasi')}}
                                </div>
                                <div class="form-box-content p-3">
                                    <div id="editProductMap" class="map mb-3"></div>
                                    <input type="hidden" class="form-control mb-3" value="{{ $product->latlong }}" name="latlong" id="latlong">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Alamat')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <textarea name="alamat" class="form-control mb-3" id="alamat" cols="20" rows="5">{{ $product->alamat }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Provinsi')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <small id="namaProv" hidden>{{ $product->provinsi }}</small>
                                            <select name="provinsi" id="provEdit" class="form-control mb-3">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Kota / Kabupaten')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <small id="namaKota" hidden>{{ $product->kota }}</small>
                                            <select name="kota" id="kotaEdit" class="form-control mb-3">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__('Kecamatan')}}</label>
                                        </div>
                                        <div class="col-md-10">
                                            <small id="namaKec" hidden>{{ $product->kecamatan }}</small>
                                            <select name="kecamatan" id="kecEdit" class="form-control mb-3">
                                                
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
                                            <input type="text" class="form-control mb-3" name="audien_target" value="{{ $product->audien_target }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Statistik / Keadaan Masyarakat')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="statistik_masyarakat" value="{{ $product->statistik_masyarakat }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Jumlah Audien / Kendaraan / Pendengar (Radio)')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="jumlah_pendengarradio" value="{{ $product->jumlah_pendengarradio }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{__('Target Audien / Pendengar (Radio)')}}</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control mb-3" name="target_pendengarradio" value="{{ $product->target_pendengarradio }}">
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
                                            <div class="row">
                                                @if ($product->pdf != null)
                                                    <div class="col-md-3">
                                                        <a href="{{ asset($product->pdf) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                                            <i class="fa fa-file-pdf-o"></i> Lihat Brosur
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm close-btn remove-files"><i class="fa fa-times"></i></button>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-box mt-4 text-right">
                                <button type="submit" class="btn btn-styled btn-base-1">{{ __('Update This Product') }}</button>
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
                    <h6 class="modal-title" id="exampleModalLabel">{{__('Select Category')}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="target-category heading-6">
                        <span class="mr-3">{{__('Target Category')}}:</span>
                        <span>{{__('Category')}} > {{__('Subcategory')}} > {{__('Sub Subcategory')}}</span>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Cancel')}}</button>
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
            $('.remove-files').on('click', function(){
                $(this).parents(".col-md-3").remove();
            });
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
        
        $(document).ready(function(){
            $('.js-example-basic-multiple').select2({
                placeholder: 'Harian / Bulanan / 6 Bulan / Tahunan'
            });
        });

        var choice_options = JSON.parse($('#choice_optionsEdit').val());
        var variations = JSON.parse($('#variationsEdit').val());

        $.each(choice_options[0].options, function(i, data){
           $('.js-example-basic-multiple option[value="'+data+'"]').prop('selected', true);
        });

        $('.js-example-basic-multiple option:selected').each(function(i, data){
            var selected = $(data).val();
            var opsi = variations[selected];
            var row =   `<tr id="row_`+selected+`">
                            <td><label class="control-label">`+selected+`</label></td>
                            <td><input type="number" name="var_price" id="var_price_`+selected+`" value="`+ opsi.price +`" min="0" step="0.01" class="form-control"></td>
                            <td><input type="text" id="var_sku_`+selected+`" value="`+ opsi.sku +`" class="form-control"></td>
                            <td><input type="number" id="var_qty_`+selected+`" value="`+ opsi.qty +`" min="0" step="1" class="form-control"></td>
                        </tr>`;
            $('#row_variations').append(row);
            function changeVariations(prop){
                $('#var_price_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].price = value;
                    $('#variationsEdit').attr('value', JSON.stringify(variations));
                });
                $('#var_sku_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].sku = value;
                    $('#variationsEdit').attr('value', JSON.stringify(variations));
                });
                $('#var_qty_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].qty = value;
                    $('#variationsEdit').attr('value', JSON.stringify(variations));
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
            if(unselected === 'Harian'){
                if(e.params.args.data.selected === true){
                    $('#unit_price').prop('readonly', true);
                }
            }
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
                    $('#row_Harian').remove();
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                case 'Bulanan':
                    $('#row_Bulanan').remove();
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                case 'EnamBulan':
                    $('#row_EnamBulan').remove();
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                case 'Tahunan':
                    $('#row_Tahunan').remove();
                    deleteVariations(unselected);
                    deleteChoice(unselected);
                    break;
                default:
                    break;
            }

            function deleteChoice(prop){
                choice_options[0].options.remove(prop);
                $('#choice_optionsEdit').attr('value', JSON.stringify(choice_options));
            }

            function deleteVariations(prop) {
                delete variations[prop];
                $('#variationsEdit').attr('value', JSON.stringify(variations));
            }
        });

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
            if(e.params.args.data.selected === false){
                $('#unit_price').prop('readonly', false);
            }
            var row = `<tr id="id_`+selected+`">
                        <td><label class="control-label">`+selected+`</label></td>
                        <td><input type="number" name="var_price" id="var_price_`+selected+`" min="0" step="0.01" class="form-control"></td>
                        <td><input type="text" id="var_sku_`+selected+`" value="`+ sku_akhir + '-' + selected +`" class="form-control"></td>
                        <td><input type="number" id="var_qty_`+selected+`" value="10" min="0" step="1" class="form-control"></td>
                       </tr>`;
            $('#row_variations').append(row);
            choice_options[0].options.push(selected);
            variations[selected] = {};
            variations[selected]['price'] = "";
            variations[selected]['sku'] = sku_akhir+'-'+selected;
            variations[selected]['qty'] = "10";
            $('#choice_optionsEdit').attr('value', JSON.stringify(choice_options));
            $('#variationsEdit').attr('value', JSON.stringify(variations));
            function changeVariations(prop){
                $('#var_price_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].price = value;
                    $('#variationsEdit').attr('value', JSON.stringify(variations));
                });
                $('#var_sku_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].sku = value;
                    $('#variationsEdit').attr('value', JSON.stringify(variations));
                });
                $('#var_qty_'+prop).on('keyup', function(){
                    var value = $(this).val();
                    variations[prop].qty = value;
                    $('#variationsEdit').attr('value', JSON.stringify(variations));
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

        // disable scrool input number
        $('form').on('focus', 'input[type=number]', function (e) {
            $(this).on('wheel.disableScroll', function (e) {
                e.preventDefault()
            })
        })
        $('form').on('blur', 'input[type=number]', function (e) {
            $(this).off('wheel.disableScroll')
        })

    	$('input[name="colors_active"]').on('change', function() {
    	    if(!$('input[name="colors_active"]').is(':checked')){
    			$('#colors').prop('disabled', true);
    		}
    		else{
    			$('#colors').prop('disabled', false);
    		}
    		update_sku();
    	});

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
