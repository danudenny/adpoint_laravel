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
                        
                        <p>Selamat.<br>
                        Proses registrasi berhasil dilakukan. Sekarang anda sudah terdaftar sebagai buyer.
                        Silahkan tekan tombol login. 
                        Anda juga dapat login versi mobile dengan cara menginstall aplikasi <a href="#">adpoint.id</a> di playstore.<p>
                        
                        <p>Terimakasih</p>
                        <p>Regards,<br>Adpoint</p>
                        <div class="center">
                            <a href="{{ route('user.login') }}" class="button button--blue">Silahkan Login</a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection