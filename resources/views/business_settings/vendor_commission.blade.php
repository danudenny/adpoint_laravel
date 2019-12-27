@extends('layouts.app')

@section('content')

    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Vendor Commission')}}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Seller</th>
                            <th>Commission</th>
                            <th>Option</th>
                            <th hidden></th>
                            <th hidden></th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" id="dataa" value="{{ $sellers }}">
                        @foreach ($sellers as $key => $s)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $s->name }}</td>
                                <td>
                                    @if ($s->commission != null)
                                        {{ $s->commission }}
                                    @else 
                                        0
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-info btn-sm" onclick="update_commission(this)"><i class="fa fa-edit"> Edit</i></button>
                                </td>
                                <td hidden>{{$s->user_id}}</td>
                                <td hidden></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function update_commission(el){
            var input_disabled = $(el).parents('tr').find("td:eq(2)");
            var input_enabled = `<input type="number" onkeyup="insert_value(this)" min="0" value='`+Number(input_disabled.html())+`' class="form-control form-control-sm">`;
            var button_edit = $(el).parents('tr').find("td:eq(3)");
            var button_save = `<button onclick="save_commission(this)" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button> | `;
            var button_cancel = `<button onclick="cancel_commission(this)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Cancel</button>`;
            input_disabled.html(input_enabled);
            button_edit.html(button_save);
            button_edit.append(button_cancel);
        }

        function cancel_commission(el){
            var input_enabled = $(el).parents('tr').find("td:eq(2)").html();
            $(el).parents('tr').find("td:eq(2)").html($(input_enabled).val());

            var button_cancel = $(el).parents('tr').find("td:eq(3)");
            button_cancel.html( `<button class="btn btn-info btn-sm" onclick="update_commission(this)"><i class="fa fa-edit"> Edit</i></button>`)
        }

        function insert_value(el){
            
            $(el).parents('tr').find("td:eq(5)").text($(el).val())
        }

        function save_commission(el){
            var seller = $(el).parents('tr').find("td:eq(1)").text();
            var com = $(el).parents('tr').find("td:eq(5)").text();
            var user_id = $(el).parents('tr').find("td:eq(4)").text();
            $.post('{{ route('business_settings.vendor_commission.update') }}', {_token:'{{ csrf_token() }}', user_id:user_id, commission:com}, function(data){
                if (data != null) {
                    showAlert('success', 'Commission Updated');
                    location.reload();
                }else{
                    showAlert('error', 'Something Wrong!');
                    location.reload();
                }
            });
        }

    </script>
@endsection
