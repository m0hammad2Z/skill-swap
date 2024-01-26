@extends('website.layouts.app')

@section('title', 'SkillSqap | Room Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/roomDetails.css') }}">
@endsection

@php
    if ($room->members->contains(Auth::user()->id)){
        echo '<script>window.location.href="/myrooms"</script>';
    }
@endphp


@section('content')
    <h1 class="section-title">{{ $room->user->first_name . ' ' . $room->user->last_name }}</h1>
    <p class="subtitle"> {{ $room->user->username }}</p>

    <div class="room-details-container">
        <div class="room-details-image">
            <img src="{{ asset('storage/'.$room->image) }}" alt="Room Image">
        </div>
        <div class="room-details">
            <div class="room-details-header">
                <h2 class="room-details-title">{{ $room->name }}</h2>
                <p class="room-details-subtitle">{{ $room->description }}</p>
            </div>

            <div class="room-details-body">
                <div class="room-details-body-item">
                    <h4 class="room-details-body-item-title">Skill to Teach</h4>
                    <p class="room-details-body-item-text">{{ $room->skill_to_teach->name }}</p>
                </div>

                <div class="room-details-body-item">
                    <h4 class="room-details-body-item-title">Skill to Learn</h4>
                    <p class="room-details-body-item-text">{{ $room->skill_to_learn->name }}</p>
                </div>

                <div class="room-details-body-item">
                    <h4 class="room-details-body-item-title">Learning Outcome</h4>
                    <p class="room-details-body-item-text">{{ $room->learning_outcomes ?? 'None' }}</p>
                </div>
                
                <div class="room-details-body-item">
                    <h4 class="room-details-body-item-title">Reqirmenets</h4>
                    <p class="room-details-body-item-text">{{ $room->requirements ?? 'None' }}</p>
                </div>

                <div class="room-details-body-item">
                    <h4 class="room-details-body-item-title">Maximum Participants</h4>
                    <p class="room-details-body-item-text">{{ $room->max_attendees }}</p>
                </div>

                <div class="room-details-body-item">
                    <h4 class="room-details-body-item-title">Current Participants</h4>
                    <p class="room-details-body-item-text">{{ $room->members->count() }}</p>
                </div>
            </div>
        </div>

        

        @php
            if ($room->members->count() == $room->max_attendees) {
                    echo '<p class="subtitle">This room is full</p>';
            }else{
                if($room->lastBooking == null || $room->lastBooking->status == 'rejected'){
                    if($room->is_private == 1){
                        echo '<input type="password" id="room-password" placeholder="Enter Room Password" class="input-field">';
                    }
                    echo '<button class="cta-button" onclick="askToJoin()">Ask to Join</button>';
                }else{
                    if( $room->lastBooking->status == 'accepted'){
                    echo '<p class="subtitle">You are already a member of this room</p>';
                    }elseif ($room->lastBooking->status == 'pending') {
                        echo '<p class="subtitle">You have already requested to join this room</p>';
                    }
                }
            }
        @endphp
    </div>
    <hr>

    <script>
        // Function to ask to join a room
        function askToJoin() {
            let ac = document.getElementById('room-password');
            if (ac == '' || ac == null || ac == undefined) {
                ac = null;
            }else{
                ac = ac.value;
            }

            fetch('/bookings/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    room_id: {{ $room->id }},
                    user_id: {{ Auth::user()->id }},
                    access_code: ac
                })
            })
            .then(res => res.json()) 
            .then(data => {
                if (data.success) {
                    toastNotification(data.message, 'success', 3000);
                    setTimeout(() => {
                        window.location.href = "/rooms";
                    }, 2000);
                } else {
                    toastNotification(data.message, 'error', 3000);
                }
            })
            .catch(error => {
                console.error(error);
                toastNotification('Something went wrong', 'error', 3000);
            });
        }


        
   
    </script>

    @endsection