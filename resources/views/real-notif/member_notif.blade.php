@php
    $user = Auth::user();
@endphp
@if ($user->user_type == "customer")
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
                <div class="media-body ml-3">
                    <a href="{{ url($data->url) }}">
                        <strong class="notification-title" style="color: black">{{ $data->title }}</strong>
                    </a>
                    <div class="notification-meta">
                        <small class="timestamp" style="color: black">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@elseif ($user->user_type == "seller")
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
                <div class="media-body ml-3">
                    <a href="{{ url($data->url) }}">
                        <strong class="notification-title" style="color: black">{{ $data->title }}</strong>
                    </a>
                    <div class="notification-meta">
                        <small class="timestamp" style="color: black">{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
@endif