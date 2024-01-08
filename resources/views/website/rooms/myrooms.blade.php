@extends('website.layouts.app')

@section('title', 'My Rooms | SkillSwap')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/myrooms.css') }}">
@endsection




@section('content')
    <h1 class="section-title">My Rooms</h1>
    <p class="subtitle">View and manage your rooms</p>

    <div class="rooms-container">
        @foreach ($rooms as $room)
            <div class="room-card">
                <div class="room-card-image">
                    <img src="https://images.ctfassets.net/23aumh6u8s0i/1IKVNqiLhNURzZXp652sEu/4379cfba19f0e19873af6074d3017f70/csharp" alt="Room Image">
                </div>
                <div class="room-card-details">
                    <div>
                        <h2 class="room-card-title">{{ $room->name }}</h2>
                        <div class="room-card-tags">
                          <span class="room-card-tag">{{ $room->user->first_name }}</span>
                        </div>
                        <p class="room-card-subtitle">{{ $room->description }}</p>
                    </div>
                </div>
                <a href="/myrooms/{{ $room->id }}" class="room-card-button cta-button ">View Room</a>

            </div>
        @endforeach
    </div>

    <hr>
@endsection

