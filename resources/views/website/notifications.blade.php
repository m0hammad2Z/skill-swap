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

        <div class="table-titles vcard">
            <strong>Room</strong>
            <strong>Message</strong>
            <strong>Action</strong>
        </div>

        <div class="vcard">
            <div class="vcard-title">
                <h4>Room 1</h4>
            </div>
            <div class="vcard__content">
                <p>Room 1 is now available</p>
            </div>
            <div class="action">
                <button class="cta-button">Mark as Read</button>
            </div>
        </div>
    </div>
</div>

@endsection