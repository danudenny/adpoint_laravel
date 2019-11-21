@extends('layouts.app')

@section('content')



<div class="row">
    <div class="col-lg-6">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title text-center">{{__('Whatsapp Settings')}}</h3>
            </div>
            <div class="panel-body">
                <button id="add_cs" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> ADD CS</button>
                <label style="float: right; margin-right: 2px">
                    <input id="active" onchange="changeValue(this)" type="checkbox" value="1" checked data-toggle="toggle">
                </label>
                <br>
                <br>
                <form id="form-wa" class="form-horizontal" action="{{ route('whatsapp_chat_update.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="wa_settings" name="whatsapp" value="{{$whatsapp_settings->value}}">
                    <div class="form-group">
                        <div class="col-md-12">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody id="row_cs">
        
                                </tbody>
                            </table>
                        </div>
                    </div>
                   
                    <div class="form-group">
                        <div class="col-md-12">
                            <label>Update Message</label>
                            <textarea class="form-control" id="msg" cols="30" rows="10"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12">
                            <button id="savebtn" class="btn btn-primary">Save configurations</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    
    
    var wa = JSON.parse($('#wa_settings').val());
    var no = 0;
    
    $('#add_cs').on('click', function(e){
        var row = `<tr id="row_`+no+`">
                    <td><input id="name_`+no+`" onkeyup="changevalue(this)" type="text" value="" class="form-control form-control-sm" placeholder="Input name"></td>
                    <td><input id="contact_`+no+`" onkeyup="changevalue(this)" type="number" class="form-control form-control-sm" value=""  placeholder="Input number wa"></td>
                    <td class="span"><span onclick="delete_row(this)" id="`+no+`" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></span></td>
                    </tr>`;
        $('#row_cs').append(row);
        add_content();
        no++; 
    });
    function add_content(e){
        wa.cs.push({name:null,contact:null});
        $('#wa_settings').attr('value', JSON.stringify(wa));
    }

    $('#msg').val(wa.message);
    $('#msg').on('keyup', function(){
        var value = $(this).val();
        wa.message = value;
        $('#wa_settings').attr('value', JSON.stringify(wa));
    })
    if (wa.active == "0") {
        $('#active').prop('checked', false);    
        $('#form-wa').hide();
        $('#add_cs').prop('disabled', true);
    }

    function changeValue(e){
        if($(e).is(':checked')){
            var value = "1";
            wa.active = value;
            $('#wa_settings').attr('value', JSON.stringify(wa));
            $('#form-wa').show();
            $('#add_cs').prop('disabled', false);
        }else{
            var value = "0";
            wa.active = value;
            $('#wa_settings').attr('value', JSON.stringify(wa));
            $('#form-wa').hide();
            $('#add_cs').prop('disabled', true);
        }
        $.post('{{ route('whatsapp_chat_update.update') }}', {_token:'{{ csrf_token() }}', value:value}, function(data){
            if(value == '1'){
                showAlert('success', 'Whatsapp settings activated');
            }else{
                showAlert('warning', 'Whatsapp settings not activated');
            }
        });
    }
    

    function changevalue(e){
        for (let i = 0; i < wa.cs.length; i++) {
            if ($(e).attr('id') == 'name_'+i) {
                var value = $(e).val();
                wa.cs[i].name = value;
                $('#wa_settings').attr('value', JSON.stringify(wa));
            }

            if ($(e).attr('id') == 'contact_'+i) {
                var value = $(e).val()
                wa.cs[i].contact = value
                $('#wa_settings').attr('value', JSON.stringify(wa));
            }
        }
    }

    function delete_row(e){
        no--;
        console.log(no);
        var id = $(e).attr('id');
        $('#row_'+id).remove()
        var arr = wa.cs;
        arr.splice(parseInt(no,10));
        wa.arr;
        $('#wa_settings').attr('value', JSON.stringify(wa));
    }

    $.each(wa.cs, function(i, data){
        var row = `<tr id="row_`+no+`">
                    <td><input id="name_`+no+`" onkeyup="changevalue(this)" type="text" class="form-control form-control-sm" value="`+data.name+`" placeholder="Input name"></td>
                    <td><input id="contact_`+no+`" onkeyup="changevalue(this)" type="number" class="form-control form-control-sm" value="`+data.contact+`" placeholder="Input number wa"></td>
                    <td class="span"><span onclick="delete_row(this)" id="`+no+`" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></span></td>
                    </tr>`;
        $('#row_cs').append(row);
        no++;
    });

    
    
</script>

@endsection
