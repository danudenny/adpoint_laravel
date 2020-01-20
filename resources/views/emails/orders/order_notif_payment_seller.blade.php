@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        <h4>Dear {{ $user['seller_name'] }},</h4>
                        
                        <p>Selamat.<br>
                            Orderan anda telah terbayar. Segera aktifkan product
                        </p>
                        <div class="center">
                            <a href="{{ route('broadcast_proof.index') }}" class="button button--blue">Aktifkan Product</a>
                        </div>
                        
                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection