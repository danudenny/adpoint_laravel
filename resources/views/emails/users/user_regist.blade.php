@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0"
            role="presentation">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        <h4>Dear, {{ $user['name'] }}!</h4>
                        
                        <p>Terima kasih telah melakukan pendaftaran di Adpoint.
                            Pendaftaran anda sedang di review oleh admin.
                            Mohon tunggu informasi selanjutnya dari kami.</p>

                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection


