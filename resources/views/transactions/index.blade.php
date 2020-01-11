@extends('layouts.app')

@section('content')

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('orders')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Code</th>
                    <th>Payment Status</th>
                    <th width="10%">{{__('options')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $key => $transaction)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $transaction->no_transaction }}</td>
                        <td>
                            @if ($transaction->payment_status == 1)
                                <span class="badge badge-success">Paid</span>
                            @else
                                <span class="badge badge-danger">Unpaid</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group dropdown">
                                <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                    {{__('Actions')}} <i class="dropdown-caret"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @if ($transaction->payment_status == 0)
                                        <li><a style="cursor: pointer;">{{__('Paid')}}</a></li>  
                                    @endif
                                    <li><a style="cursor: pointer;" onclick="show_transaction_details({{ $transaction->id }})">{{__('Details')}}</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            
        </table>

    </div>
</div>

<div class="modal fade" id="transaction_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
        <div class="modal-content position-relative">
            <div class="c-preloader">
                <i class="fa fa-spin fa-spinner"></i>
            </div>
            <div id="transaction-detail-modal-body">

            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
    <script>
        function show_transaction_details(transaction_id) {
            $('#transaction-detail-modal-body').html(null);

            if(!$('#modal-size').hasClass('modal-lg')){
                $('#modal-size').addClass('modal-lg');
            }

            $.post('{{ route('transaction.details') }}', { _token : '{{ @csrf_token() }}', transaction_id : transaction_id}, function(data){
                $('#transaction-detail-modal-body').html(data);
                $('#transaction_detail').modal();
                $('.c-preloader').hide();
            });
        }
    </script>
@endsection
