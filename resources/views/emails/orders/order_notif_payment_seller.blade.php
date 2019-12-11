@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <p>Dear {{ $user['seller_name'] }},</p>
                    
                    <p>Selamat.<br>
                        Orderan anda telah terbayar. Segera aktifkan product
                    </p>
                    <div class="center">
                        <a href="{{ route('bukti.tayang', encrypt($user['order_id'])) }}" class="button button--blue">Aktifkan Product</a>
                    </div>
                    
                    <p>Terimakasih</p>
                    <p>Regards,<br>Adpoint</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection