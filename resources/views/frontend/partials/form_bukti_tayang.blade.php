<div class="modal-header">
    <h5 class="modal-title strong-600 heading-5">
        # {{ \App\Product::where('id', $order_active->product_id)->first()->name }}
    </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body px-3 pt-0">
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('upload.bukti.tayang') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        @csrf
                        <div class="form-group">
                            <label>Type File</label>
                            <select class="js-example-basic-multiple" id="type-file" multiple="multiple">
                                <option value="gambar">Gambar</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <td class="text-center">
                                            Type File
                                        </td>
                                        <td class="text-center">
                                            Upload File
                                        </td>
                                        <td class="text-center">
                                            Created at
                                        </td>
                                    </tr>
                                </thead>
                                <tbody id="body-type-file">
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info">Submit Data</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No Bukti Tayang</label>
                            <input type="text" value="#" name="no_bukti" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>No Order</label>
                            <input type="text" value="#" name="no_order" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    $('#type-file').select2({
        placeholder: 'Gambar / Video',
    });

    // selecting
    $('#type-file').on('select2:selecting', function(e){
        var selected = e.params.args.data.id; 
        date = new Date();
                
        var row = `<tr id="row_`+selected+`">
                    <td><label>`+ capitalize(selected) +`</label></td>
                    <td><input type="file" name="file`+selected+`[]" class="form-control"></td>
                    <td><input type="text" name="desc`+selected+`[]" value="`+date.toDateString()+`" class="form-control"></td>
                    <td><span id="addfile_`+selected+`" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></span></td>
                </tr>`;
        $('#body-type-file').append(row);

        $('#addfile_'+selected).on('click', function(){
            var id_row = '#row_'+selected;
            $(id_row+' td:nth-child(2)').append(`<input type="file" name="file`+selected+`[]" class="form-control mt-2">`);
            $(id_row+' td:nth-child(3)').append(`<input type="text" name="desc`+selected+`[]" value="`+date.toDateString()+`" class="form-control mt-2">`);
        })
    })

    // unselecting
    $('#type-file').on('select2:unselecting', function(e){
        var unselected = e.params.args.data.id;
        var id_row = '#row_'+unselected;
        $(id_row).remove();
    })
</script>