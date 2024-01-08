@extends('website.layouts.app')

@section('title', 'SkillSqap | Room Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/roomDetails.css') }}">
@endsection


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
                    <h3 class="room-details-body-item-title">Skill to Teach</h3>
                    <p class="room-details-body-item-text">{{ $room->skill_to_teach->name }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Skill to Learn</h3>
                    <p class="room-details-body-item-text">{{ $room->skill_to_learn->name }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Learning Outcome</h3>
                    <p class="room-details-body-item-text">{{ $room->learning_outcomes ?? 'None' }}</p>
                </div>
                
                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Reqirmenets</h3>
                    <p class="room-details-body-item-text">{{ $room->requirements ?? 'None' }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Maximum Participants</h3>
                    <p class="room-details-body-item-text">{{ $room->max_attendees }}</p>
                </div>

                <div class="room-details-body-item">
                    <h3 class="room-details-body-item-title">Current Participants</h3>
                    <p class="room-details-body-item-text">{{ $room->members->count() }}</p>
                </div>
            </div>
        </div>
        <a href="/rooms/{{ $room->id }}/" class="cta-button">Ask to Join</a>
    </div>
    <hr>
    <script>
        function toastNotification(title, icon, timer = 3000) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timer,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                didClose: (toast) => {
                    toast.removeEventListener('mouseenter', Swal.stopTimer)
                    toast.removeEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: icon,
                title: title
            })
        }
    </script>

    @endsection