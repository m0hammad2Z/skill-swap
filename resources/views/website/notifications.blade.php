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
                <strong>Action</strong>
            </div>

                @foreach($notifications as $notification)
                <div class="vcard" id="notification-{{ $notification->id }}" style="cursor: pointer;" onclick="window.location.href='/bookings{{$notification->url}}'">
                    <div class="vcard-title">
                        <h4> {{ $notification->type }} </h4>
                    </div>
                    <div class="vcard__content">
                        <p> {{ $notification->message }} </p>
                    </div>
                    <div class="action">
                        <button class="cta-button">Mark as Read</button>
                    </div>
                </div>
                @endforeach
        @endif

    </div>
</div>

@endsection