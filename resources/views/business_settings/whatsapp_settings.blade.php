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
                    <input id="active" type="checkbox" value="1" checked data-toggle="toggle">
                </label>
                <br>
                <br>
                <form class="form-horizontal" action="{{ route('whatsapp_chat_update.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="wa_settings" name="whatsapp" class="form-control" value="{{$whatsapp_settings->value}}">
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
                            <button class="btn btn-primary">Save configurations</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    
    
    var wa = JSON.parse($('#wa_settings').val());
    var obj = {name:null,contact:null};
    $('#msg').val(wa.message);
    $('#msg').on('keyup', function(){
        var value = $(this).val();
        wa.message = value;
        $('#wa_settings').attr('value', JSON.stringify(wa));
    })
    $('#active').on('change', function(e){
        var value = $(this).val();
    })
    var no = 0;
    $('#add_cs').on('click', function(e){
        var row = `<tr id="row_`+no+`">
                    <td><input id="name_`+no+`" onkeyup="changevalue(this)" type="text" value="" class="form-control form-control-sm" placeholder="Input name"></td>
                    <td><input id="contact_`+no+`" onkeyup="changevalue(this)" type="number" class="form-control value="" form-control-sm" placeholder="Input number wa"></td>
                    <td><span onclick="delete_row(this)" id="`+no+`" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></span></td>
                    </tr>`;
        $('#row_cs').append(row);
        add_content();
        no++; 
    });

    function changevalue(e){
        // name
        if ($(e).attr('id') == 'name_0') {
            var value = $(e).val()
            wa.cs[0].name = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'name_1') {
            var value = $(e).val()
            wa.cs[1].name = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'name_2') {
            var value = $(e).val()
            wa.cs[2].name = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'name_3') {
            var value = $(e).val()
            wa.cs[3].name = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'name_4') {
            var value = $(e).val()
            wa.cs[4].name = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        // end name

        // contact
        if ($(e).attr('id') == 'contact_0') {
            var value = $(e).val()
            wa.cs[0].contact = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'contact_1') {
            var value = $(e).val()
            wa.cs[1].contact = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'contact_2') {
            var value = $(e).val()
            wa.cs[2].contact = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'contact_3') {
            var value = $(e).val()
            wa.cs[3].contact = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
        if ($(e).attr('id') == 'contact_4') {
            var value = $(e).val()
            wa.cs[4].contact = value
            $('#wa_settings').attr('value', JSON.stringify(wa));
        }
    }

    function add_content(e){
        wa.cs.push(obj);
        $('#wa_settings').attr('value', JSON.stringify(wa));
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
                    <td><span onclick="delete_row(this)" id="`+no+`" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></span></td>
                    </tr>`;
        $('#row_cs').append(row);
        no++;
    });

    
    
</script>

@endsection
