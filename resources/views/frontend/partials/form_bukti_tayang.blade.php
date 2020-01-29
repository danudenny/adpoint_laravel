<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        # {{ \App\Product::where('id', $order_active->product_id)->first()->name }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body px-3 pt-0">
    @php
        $evidence = \App\Evidence::where('order_detail_id', $order_active->id)->first();
    @endphp
    <br>
    @if ($evidence !== null)
    <form action="{{ route('update.bukti.tayang') }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                @csrf
                <input type="hidden" name="order_detail_id" value="{{ $evidence->order_detail_id }}">
                <div class="form-group">
                    <label>No Bukti Tayang</label>
                    <input type="text" value="{{ $evidence->no_bukti }}" name="no_bukti" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>No Order</label>
                    <input type="text" value="{{ $evidence->no_order }}" name="no_order" class="form-control" readonly>
                </div>

                @php
                    $typefile = json_decode($evidence->file);
                @endphp
                
                <div class="form-group">
                    <label>Image</label>
                    <div id="upload-images">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="text-left">
                                    <button type="button" class="btn btn-info" onclick="add_more_image()"><i class="fa fa-plus"></i></button>
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

                <div class="row">
                    @if ($typefile->gambar !== null)
                        @foreach ($typefile->gambar as $key => $image)
                            <div class="col-md-4">
                                <div class="img-upload-preview">
                                    <img src="{{ url($image) }}" alt="" width="100" class="img-responsive">
                                    <input type="hidden" id="image_prev" name="image_prev[]" value="{{ $image }}">
                                    <button type="button" class="btn btn-danger btn-sm btn-circle close-btn remove-files" onclick="remove_file_image({{ $evidence->id }}, this)"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="form-group">
                    <label>Video</label>
                    <div id="upload-videos">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="text-left">
                                    <button type="button" class="btn btn-info" onclick="add_more_video()"><i class="fa fa-plus"></i></button>
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

                <div class="row">
                @if ($typefile->video !== null)
                    @foreach ($typefile->video as $key => $video)
                        <div class="col-md-4">
                            <div class="img-upload-preview">
                                <img src="{{ url($video) }}" alt="" width="100" class="img-responsive">
                                <input type="hidden" id="video_prev" name="video_prev[]" value="{{ $video }}">
                                <button type="button" class="btn btn-danger btn-sm btn-circle close-btn remove-files" onclick="remove_file_video({{ $evidence->id }}, this)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    @endforeach
                @endif
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-success">Update Data</button>
                </div>
            </div>
        </div>
    </form>    
    @else
    <form action="{{ route('upload.bukti.tayang') }}" method="POST" enctype="multipart/form-data"> 
        <div class="row">
            <div class="col-md-12">
                @csrf
                <input type="hidden" name="order_detail_id" value="{{ $order_active->id  }}">
                <div class="form-group">
                    <label>No Bukti Tayang</label>
                    <input type="text" value="BT-{{ time().$order_active->id }}" name="no_bukti" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>No Order</label>
                    <input type="text" value="{{ $order_active->o_code }}" name="no_order" class="form-control" readonly>
                </div>
                
                <div class="form-group">
                    <label>Image</label>
                    <div id="upload-images">
                        <div class="row">
                            <div class="col-md-1">
                                <div class="text-left">
                                    <button type="button" class="btn btn-info" onclick="add_more_image()"><i class="fa fa-plus"></i></button>
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
                                    <button type="button" class="btn btn-info" onclick="add_more_video()"><i class="fa fa-plus"></i></button>
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
                    <button type="submit" class="btn btn-block btn-info">Submit Data</button>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>

<script>

        function remove_file_image(id, el) {
            $(el).parents(".col-md-4").remove();
            var value = $(el).prev('#image_prev').val();
            $.post('{{ route('delete.file.image') }}',{_token:'{{ csrf_token() }}', id:id, val:value}, function(data){
                console.log(data);
            });

        }

        function remove_file_video(id, el) {
            $(el).parents(".col-md-4").remove();
            var value = $(el).prev('#video_prev').val();
            $.post('{{ route('delete.file.video') }}',{_token:'{{ csrf_token() }}', id:id, val:value}, function(data){
                console.log(data);
            });
        }

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