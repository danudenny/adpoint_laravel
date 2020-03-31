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
                        @php
                            $email = \App\BusinessSetting::where('type','email_settings')->first()->value;
                            $value = json_decode($email);
                            $content = "";
                            foreach ($value->data as $key => $d) {
                                if ($d->judul == "Reject User") {
                                    $content = $d->content;
                                }
                            }
                        @endphp
                        {!! $content !!}

                        <p>Terimakasih</p>
                        <p>Regards,<br>InnovAPS</p>
                    </div>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endsection
