@extends('website.layouts.app')

@section('title', 'SkillSqap | Room Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/roomDetails.css') }}">
@endsection

@section('links')
    <button class="cta-button" onclick="window.location.href='/rooms'">Back to Rooms</button>
@endsection

@php
    $room = (object) [
        'id' => '1',
        'name' => 'Sample Room',
        'description' => 'This is a sample room description.',
        'duration' => 60,
        'meeting_date' => '2022-12-31',
        'meeting_time' => '10:00 AM',
        'max_participants' => 10,
        'tags' => 'tag1, tag2, tag3',
        'type' => 'Meeting Room',
    ];
@endphp

@section('content')
    <h1 class="section-title">Ahmad Saeed</h1>
    <p class="subtitle">Web Skills</p>

    <div class="room-details-container">
        <div class="room-details-image">
            <img src="https://images.ctfassets.net/23aumh6u8s0i/1IKVNqiLhNURzZXp652sEu/4379cfba19f0e19873af6074d3017f70/csharp" alt="Room Image">
        </div>
        <div class="room-details">
            <div class="room-details-header">
                <h2 class="room-details-title">{{ $room->name }}</h2>
                <p class="room-details-subtitle">{{ $room->description }}</p>
            </div>

            <div class="room-details-body">
                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Room Duration</h3>
                    <p class="room-details-body-item-text">{{ $room->duration }} minutes</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Meeting Date</h3>
                    <p class="room-details-body-item-text">{{ $room->meeting_date }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Meeting Time</h3>
                    <p class="room-details-body-item-text">{{ $room->meeting_time }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Maximum Participants</h3>
                    <p class="room-details-body-item-text">{{ $room->max_participants }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Room Tags</h3>
                    <p class="room-details-body-item-text">{{ $room->tags }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Room Type</h3>
                    <p class="room-details-body-item-text">{{ $room->type }}</p>
                </div>
            </div>
        </div>
        <a href="/rooms/{{ $room->id }}/" class="cta-button">Join Room</a>
    </div>
    <hr>
    @endsection