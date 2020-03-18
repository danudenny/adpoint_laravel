@php
    $user = Auth::user();
@endphp
@foreach ($user->unreadNotifications as $notif)
    @php
        $data = json_decode(json_encode($notif->data))
    @endphp
    <li class="notification active">
        <div class="media">
            <div class="media-left">
                <div class="media-object">
                  <img src="{{ url('img/logo_shop.png') }}" class="img-circle" alt="50x50" style="width: 50px; height: 50px;">
                </div>
            </div>
            <div class="media-body">
            <strong class="notification-title">{{ $data->title }}</strong>
            <!--p class="notification-desc">Extra description can go here</p-->
            <div class="notification-meta">
                <small class="timestamp">{{ $notif->created_at }}</small>
            </div>
            </div>
        </div>
    </li>
@endforeach