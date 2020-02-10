@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <!-- <a href="{{ route('sellers.create')}}" class="btn btn-info pull-right">{{__('add_new')}}</a> -->
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Customers')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Email Address')}}</th>
                    <th>{{__('Phone')}}</th>
                    <th>{{__('Address')}}</th>
                    <th>{{__('City')}}</th>
                    <th>{{__('Status')}}</th>
                    <th>{{__('Created')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $key => $customer)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$customer->name}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->phone}}</td>
                        <td width="25%">{{$customer->address}}</td>
                        <td>{{$customer->city}}</td>
                        @if ($customer->verified == 1)
                            <td><span class="badge badge-success">Verified</span></td>
                        @else
                            <td><span class="badge badge-danger" onclick="verifyUser({{$customer->id}})" data-toggle="tooltip" data-placement="top" style="cursor: pointer;" title="Verified Now">Not Verified</span></td>
                        @endif
                        <td>{{date('d F Y', strtotime($customer->created_at))}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>





<script>
    function acceptUser(id) {
        $('#acc').html(`<i class="fa fa-spinner"></i> Loading...`);
        $.post('{{ route('customer.accept') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
            if (data) {
                location.reload();
                showAlert('success', 'Customer has been verified');
            }
            $('#acc').html(`Accept`);
        });
    }
    function rejectUser(id) {
        $('#rjt').html(`<i class="fa fa-spinner"></i> Loading...`);
        $.post('{{ route('customer.reject') }}',{_token:'{{ csrf_token() }}', id:id}, function(data){
            if (data) {
                location.reload();
                showAlert('danger', 'Customer has been rejected');
            }
            $('#rjt').html(`Reject`);
        });
    }
    function verifyUser(id){
        $('#content-body').html(null);
        $('#addToCart').modal();
        $('.c-preloader').show();
        $.ajax({
            url: '{{ route('customer.show_customer') }}',
            type: 'POST',
            dataType: 'json',
            data: {
                _token:'{{ csrf_token() }}',
                id:id
            },
            success: function(data){
                var base_url = {!! json_encode(url('/')) !!};
                var ktp = base_url+'/'+data[0].ktp;
                var npwp = base_url+'/'+data[0].npwp;
                $('.c-preloader').hide();
                var temp = `<div class="card">
                            <h5 class="card-header">Detail Customer</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <tr>
                                            <td>Name</td>
                                            <td>:</td>
                                            <td style="text-align: left">`+data[0].name+`</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td style="text-align: left">`+data[0].email+`</td>
                                        </tr>
                                        <tr>
                                            <td>User type</td>
                                            <td>:</td>
                                            <td style="text-align: left">`+data[0].user_type+`</td>
                                        </tr>
                                        <tr>
                                            <td>Created</td>
                                            <td>:</td>
                                            <td style="text-align: left">`+data[0].created_at+`</td>
                                        </tr>
                                        <tr>
                                            <td>Document KTP</td>
                                            <td>:</td>
                                            <td id="ktp"><a href="`+ktp+`" target="_blank"><img src="`+ktp+`" class="img-fluid img-thumbnail" width="150"></a></td>
                                        </tr>
                                        <tr>
                                            <td>Document NPWP</td>
                                            <td>:</td>
                                            <td id="npwp"><a href="`+npwp+`" target="_blank"><img src="`+npwp+`" class="img-fluid img-thumbnail" width="150"></a></td>
                                        </tr>
                                    </table>
                                    <button id="acc" onclick="acceptUser(`+data[0].id+`)" type="button" class="btn btn-primary btn-sm">Accept</button>
                                    <button id="rjt" onclick="rejectUser(`+data[0].id+`)" type="button" class="btn btn-danger btn-sm">Reject</button></<button>
                                </div>
                            </div>
                            </div>`;
                $('#content-body').html(temp);
                if (data[0].ktp == '') {
                    $('#ktp').html(`<span class="badge badge-warning">KTP Tidak ada</span>`);
                }
                if (data[0].npwp == '') {
                    $('#npwp').html(`<span class="badge badge-warning">NPWP Tidak ada</span>`);
                }                
            }
        })
    }
</script>

@endsection

