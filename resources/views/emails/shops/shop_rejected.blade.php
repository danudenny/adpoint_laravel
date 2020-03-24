@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        <h4>Dear {{ $user->name }},</h4>
                        
                        <p>Maaf.<br>
                            Permintaan anda menjadi media owner, tidak kami setujui.
                            karena dokumen yang anda kirim tidak sesuai.
                        <p>
                        
                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection