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
                        
                        <p>Reset Password anda, silahkan klik tombol reset password.</p>
                        <div class="center">
                            <a href="{{ url('/users/change-password?email='.$user['email'].'&token='.urlencode($user['token']).'') }}" class="button button--red">Reset Password</a>
                        </div>
                        <br>
                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection