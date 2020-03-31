@extends('emails.template')
@section('content')
<tr>
    <td class="email-body" width="100%">
        <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
            <!-- Body content -->
            <tr>
                <td class="content-cell">
                    <div class="f-fallback">
                        <h4>Dear {{ $user['name'] }},</h4>

                        <p>Mohon maaf.<br>
                            Sayaang nya orderan anda kami tolak.
                        </p>

                        <p>Terimakasih</p>
                        <p>Regards,<br>InnovAPS</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
