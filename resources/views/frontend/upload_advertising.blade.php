@extends('frontend.layouts.app')

@section('content')

    <div id="page-content">
        <section class="slice-xs sct-color-2 border-bottom">
            <div class="container container-sm">
                <div class="row cols-delimited">
                    <div class="col-3">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-shopping-cart"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">1. {{__('My Cart')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-truck"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">2. {{__('Billing info')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon c-gray-light mb-0">
                                <i class="la la-cloud-upload" style="color: #ff9400"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">3. {{__('Upload Advertising')}}</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon-block icon-block--style-1-v5 text-center">
                            <div class="block-icon mb-0">
                                <i class="la la-credit-card" style="color: #6c757d"></i>
                            </div>
                            <div class="block-content d-none d-md-block">
                                <h3 class="heading heading-sm strong-300 c-gray-light text-capitalize">4. {{__('Payment')}}</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>




        <section class="py-3 gry-bg">
            <div class="container">
                <div class="row cols-xs-space cols-sm-space cols-md-space">
                    <div class="col-lg-8">
                        <form action="{{ route('checkout.store_shipping_infostore') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card">
                                <div class="card-title px-4 py-3">
                                    <h3 class="heading heading-5 strong-500">
                                        {{__('Upload advertising')}}
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-success" role="alert">
                                                <h4 class="alert-heading">Well done!</h4>
                                                <p>You are now please prepare the materials that you want to upload!</p>
                                                <hr>
                                                <p class="mb-0">And provide information to the seller clearly</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Image</label>
                                                        <div id="upload-images">
                                                            <div class="row">
                                                                <div class="col-md-1">
                                                                    <div class="text-left">
                                                                        <button type="button" class="btn btn-default" onclick="add_more_image()"><i class="fa fa-plus"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-11">
                                                                    <input type="file" name="image[]" id="image-1" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                                    <label for="image-1" class="mw-100 mb-3">
                                                                        <span></span>
                                                                        <strong>
                                                                            <i class="fa fa-upload"></i>
                                                                        </strong>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Video</label>
                                                        <div id="upload-videos">
                                                            <div class="row">
                                                                <div class="col-md-1">
                                                                    <div class="text-left">
                                                                        <button type="button" class="btn btn-default" onclick="add_more_video()"><i class="fa fa-plus"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-11">
                                                                    <input type="file" name="video[]" id="video-1" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" accept="image/*" />
                                                                    <label for="video-1" class="mw-100 mb-3">
                                                                        <span></span>
                                                                        <strong>
                                                                            <i class="fa fa-upload"></i>
                                                                        </strong>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description <span class="text-danger">*</span></label>
                                                        <textarea name="desc_ads" class="form-control" cols="10" rows="5" placeholder="And provide information to the seller clearly" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center pt-4">
                                <div class="col-6">
                                    <a href="{{ route('home') }}" class="link link--style-3">
                                        <i class="ion-android-arrow-back"></i>
                                        {{__('Return to shop')}}
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="submit" class="btn btn-styled btn-base-1">{{__('Continue To Payment')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-4 ml-lg-auto">
                        @include('frontend.partials.cart_summary')
                    </div>
                    
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        var img_id = 2;
        function add_more_image(){
            var photoAdd =  '<div class="row">';
            photoAdd +=  '<div class="col-md-1">';
            photoAdd +=  '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            photoAdd +=  '</div>';
            photoAdd +=  '<div class="col-md-11">';
            photoAdd +=  '<input type="file" name="image[]" id="image-'+img_id+'" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />';
            photoAdd +=  '<label for="image-'+img_id+'" class="mw-100 mb-3">';
            photoAdd +=  '<span></span>';
            photoAdd +=  '<strong>';
            photoAdd +=  '<i class="fa fa-upload"></i>';
            photoAdd +=  '</strong>';
            photoAdd +=  '</label>';
            photoAdd +=  '</div>';
            photoAdd +=  '</div>';
            $('#upload-images').append(photoAdd);

            img_id++;
            imageInputInitialize();
        }

        var vid_id = 2;
        function add_more_video(){
            var photoAdd =  '<div class="row">';
            photoAdd +=  '<div class="col-md-1">';
            photoAdd +=  '<button type="button" onclick="delete_this_row(this)" class="btn btn-link btn-icon text-danger"><i class="fa fa-trash-o"></i></button>';
            photoAdd +=  '</div>';
            photoAdd +=  '<div class="col-md-11">';
            photoAdd +=  '<input type="file" name="video[]" id="video-'+vid_id+'" class="custom-input-file custom-input-file--4" data-multiple-caption="{count} files selected" multiple accept="image/*" />';
            photoAdd +=  '<label for="video-'+vid_id+'" class="mw-100 mb-3">';
            photoAdd +=  '<span></span>';
            photoAdd +=  '<strong>';
            photoAdd +=  '<i class="fa fa-upload"></i>';
            photoAdd +=  '</strong>';
            photoAdd +=  '</label>';
            photoAdd +=  '</div>';
            photoAdd +=  '</div>';
            $('#upload-videos').append(photoAdd);

            vid_id++;
            imageInputInitialize();
        }

        function delete_this_row(em){
            $(em).closest('.row').remove();
        }

        // old function

        function capitalize(string) {
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }


        $('#type-file').select2({
            placeholder: 'Gambar / Video / Zip',
        });

        $('#type-file').on('select2:selecting', function(e){
            var selected = e.params.args.data.id; 
            date = new Date();
                    
            var row = `<tr id="row_`+selected+`">
                        <td><label>`+ capitalize(selected) +`</label></td>
                        <td><input type="file" name="file`+selected+`[]" class="form-control form-control-sm"></td>
                        <td><span id="addfile_`+selected+`" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></span></td>
                        </tr>`;
            $('#body-type-file').append(row);

            $('#addfile_'+selected).on('click', function(){
                var id_row = '#row_'+selected;
                $(id_row+' td:nth-child(2)').append(`<input type="file" name="file`+selected+`[]" class="form-control form-control-sm mt-2">`);
            })
        })

        $('#type-file').on('select2:unselecting', function(e){
            var unselected = e.params.args.data.id;
            var id_row = '#row_'+unselected;
            $(id_row).remove();
        })

        function use_wallet(){
            $('input[name=payment_option]').val('wallet');
            $('#checkout-form').submit();
        }
    </script>
@endsection
