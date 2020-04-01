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

                         <p>Terimakasih.<br>
                             Anda sudah melakukan order. Mohon menunggu orderan di review admin
                             @php
                                 $data = json_encode($user['data'])
                             @endphp
                             {{ $data }}
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
