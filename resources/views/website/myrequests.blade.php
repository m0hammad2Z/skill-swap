@extends('website.layouts.app')

@section('title', 'Notifications')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endsection

@section('content')

<div class="container">
    <div id="resourceList">
        <h1 class="section-title">My Requests</h1>
        <h1 class="subtitle">You have 2 unread notifications</h2>

        <div class="table-titles vcard">
            <strong>Room</strong>
            <strong>Date</strong>
            <strong>Action</strong>
        </div>

        <div class="vcard">
            <div class="vcard-title">
                <h4>Room 1</h4>
            </div>
            <div class="date vcard__content">
                <p>2021-03-01</p>
            </div>
            <div class="action">
                <button class="cta-button">Accept</button>
                <button class="red-button">Delete</button>
            </div>
        </div>
        
    </div>
</div>

@endsection