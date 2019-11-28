@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <p>Dear {{ $user['name'] }},</p>
                    
                    <p>Terimakasih telah melakukan pendafataran.<br>
                    Maaf pendaftaran anda <b>ditolak</b> karena data yang anda masukkan tidak sesuai.
                    Silahkan melakukan pendaftaran kembali.<p>
                    
                    <p>Terimakasih</p>
                    <p>Regards,<br>Adpoint</p>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection