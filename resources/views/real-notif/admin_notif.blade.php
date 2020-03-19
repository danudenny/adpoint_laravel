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
                  <i class="fa fa-bell fa-3x"></i>
                </div>
            </div>
            <div class="media-body">
                <a href="{{ url($data->url) }}">
                    <strong class="notification-title">{{ $data->title }}</strong>
                </a>
                <div class="notification-meta">
                    <small class="timestamp">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </li>
@endforeach