@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <p>Dear {{ $user['buyer_name'] }},</p>
                    
                    <p>Terimakasih.<br>
                        Anda telah melakukan pembayaran
                    </p>
                    
                    <p>Terimakasih</p>
                    <p>Regards,<br>Adpoint</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection