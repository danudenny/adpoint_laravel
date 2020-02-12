<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        @php
            $cart = Session::get('cart');
            $product_id = $cart[$data['seller_id']][$data['index']]['id'];
            $product = \App\Product::where('id', $product_id)->first();
        @endphp
        # {{$product->name}}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body px-3 pt-0">
    <div class="row mt-4">
        <div class="col-md-12">
            <h4 class="text-center">Upload this here</h4>
            <hr>
            <form action="{{ route('upload.ads.proses') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="seller_id" value="{{$data['seller_id']}}">
                <input type="hidden" name="index" value="{{$data['index']}}">
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
                    <button class="btn btn-outline-info btn-block">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
</script>