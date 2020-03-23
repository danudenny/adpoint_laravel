@php
    $user = Auth::user();
@endphp
@foreach ($user->notifications as $notif)
    @php
        $data = json_decode(json_encode($notif->data))
    @endphp
    <li class="notification active">
        <div class="media">
            <div class="media-left">
                <div class="media-object">
                <i class="fa fa-bell fa-3x" @if ($notif->read_at !== null) style="color: grey" @else style="color: black" @endif></i>
                </div>
            </div>
            <div class="media-body ml-3">
                <a href="{{ url($data->url) }}">
                    <strong class="notification-title" @if ($notif->read_at !== null) style="color: grey" @else style="color: black" @endif>{{ $data->title }}</strong>
                </a>
                <div class="notification-meta">
                    <small class="timestamp" @if ($notif->read_at !== null) style="color: grey" @else style="color: black" @endif>{{ $notif->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </li>
@endforeach