@php
    $user = Auth::user();
@endphp
<ul class="list-group list-group-flush">
    @if ($user->unreadNotifications->count() > 0)
        @foreach ($user->unreadNotifications as $notif)
            @php
                $data = json_decode(json_encode($notif->data))
            @endphp
            <li class="list-group-item list-group-item-action">
                <a href="#" style="color:black">{{ $data->title }}</a>
            </li>
        @endforeach
    @else 
        <li class="list-group-item list-group-item-action">
            <div class="text-center">
                <b>You have not notification</b>
            </div>
        </li>
    @endif
</ul>
