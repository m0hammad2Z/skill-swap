@extends('website.layouts.app')

@section('title', 'My Rooms | SkillSwap')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/myrooms.css') }}">
@endsection

@section('links')
    <button class="cta-button" onclick="window.location.href='/rooms/create'">Create Room</button>
@endsection

@php
  $rooms = [
    (object) [
      'id' => '1',
      'name' => 'Sample Room',
      'description' => 'This is a sample room description.',
      'duration' => 60,
      'meeting_date' => '2022-12-31',
      'meeting_time' => '10:00 AM',
      'max_participants' => 10,
      'tags' => 'tag1, tag2, tag3',
      'type' => 'Meeting Room',
    ],
    (object) [
      'id' => '2',
      'name' => 'Sample Room',
      'description' => 'This is a sample room description.',
      'duration' => 60,
      'meeting_date' => '2022-12-31',
      'meeting_time' => '10:00 AM',
      'max_participants' => 10,
      'tags' => 'tag1, tag2, tag3',
      'type' => 'Meeting Room',
    ],
    (object) [
      'id' => '3',
      'name' => 'Sample Room',
      'description' => 'This is a sample room description.',
      'duration' => 60,
      'meeting_date' => '2022-12-31',
      'meeting_time' => '10:00 AM',
      'max_participants' => 10,
      'tags' => 'tag1, tag2, tag3',
      'type' => 'Meeting Room',
    ],
    (object) [
      'id' => '4',
      'name' => 'Sample Room',
      'description' => 'This is a sample room description.',
      'duration' => 60,
      'meeting_date' => '2022-12-31',
      'meeting_time' => '10:00 AM',
      'max_participants' => 10,
      'tags' => 'tag1, tag2, tag3',
      'type' => 'Meeting Room',
    ],
    (object) [
      'id' => '5',
      'name' => 'Sample Room',
      'description' => 'This is a sample room description.',
      'duration' => 60,
      'meeting_date' => '2022-12-31',
      'meeting_time' => '10:00 AM',
      'max_participants' => 10,
        'tags' => 'tag1, tag2, tag3',
        'type' => 'Meeting Room',
    ],
    (object) [
      'id' => '6',
      'name' => 'Sample Room',
      'description' => 'This is a sample room description.',
      'duration' => 60,
      'meeting_date' => '2022-12-31',
      'meeting_time' => '10:00 AM',
      'max_participants' => 10,
      'tags' => 'tag1, tag2, tag3',
      'type' => 'Meeting Room',
    ],
];
@endphp


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
                            @foreach (explode(',', $room->tags) as $tag)
                                <span class="room-card-tag">{{ $tag }}</span>
                            @endforeach
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

