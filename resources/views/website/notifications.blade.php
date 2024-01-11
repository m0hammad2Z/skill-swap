@extends('website.layouts.app')

@section('title', 'Notifications')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endsection



@section('content')

<div class="container">
    <div id="resourceList">
        <h1 class="section-title">Notifications</h1>
        <p class="subtitle">Here you can see all the notifications you have received.</p>

        @if ($notifications->count() == 0)
            <div class="empty" style="text-align: center; margin: 8em auto;">
                <i class="fas fa-envelope" style="font-size: 9em;"></i>
                <h1>No Notifications Yet!</h1>
                <p>Once you receive a notification, it will appear here</p>
            </div>
        @else

            <div class="table-titles vcard">
                <strong>Room</strong>
                <strong>Message</strong>
            </div>

                @foreach($notifications as $notification)
                <div class="vcard" style="cursor: pointer; background-color: {{ $notification->is_read == 0 ? 'var(--glass-color)' : 'trasnparent' }};" onclick="markAsRead({{ $notification->id }})" >
                    <div class="vcard-title">
                        <h4> {{ $notification->type }} </h4>
                    </div>
                    <div class="vcard__content">
                        <p> {{ $notification->message }} </p>
                    </div>
                </div>
                @endforeach
        @endif

        
    </div>
</div>

<script>

    async function markAsRead(id){
        const route = `/notifications/markAsRead/${id}`;
        console.log(route);
        let response = await request(id, route);
        if(response.success){
            window.location.href='/bookings{{$notification->url}}'
        }
        else{
            toastNotification(response.message, 'error', 3000);
        }
    }


    async function request(id, route){
        try{
            let response = await fetch(route, {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/json',
                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })

            return await response.json();

        }catch(e)
        {
            return {
                success: false,
                message: "Something went wrong"
            }
        }
    }
</script>


@endsection