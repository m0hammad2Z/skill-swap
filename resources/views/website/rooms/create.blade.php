@extends('website.layouts.app')

@section('title', 'SkillSqap | Create New Room')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

<!-- Navbar -->
@section('links')
    <a href="/">Home</a>
    <a href="/rooms">Rooms</a>
    <a href="/requests">Requests</a>
    <a href="/offers">Offers</a>
@endsection

@section('button')
    <button class="cta-button" onclick="window.location.href='/create'">Create a Room</button>
@endsection

@section('content')
    <h1 class="section-title">Create a Room</h1>
    <p class="subtitle">Fill out the form below to create a room.</p>

    <div class="form-container">
        <form>
            <div class="form-group">
                <label for="roomDuration">Room Duration (in minutes)</label>
                <input type="number" id="roomDuration" name="roomDuration" min="1">
            </div>
            
            <!-- Meeting Date and Time Fields -->
            <div class="form-group">
                <label for="meetingDate">Meeting Date</label>
                <input type="date" id="meetingDate" name="meetingDate">
            
                <label for="meetingTime">Meeting Time</label>
                <input type="time" id="meetingTime" name="meetingTime">
            </div>
            
            <!-- Room Capacity Field -->
            <div class="form-group">
                <label for="maxParticipants">Maximum Participants</label>
                <input type="number" id="maxParticipants" name="maxParticipants" min="1">
            </div>
            
            <!-- Room Tags Field -->
            <div class="form-group">
                <label for="roomTags">Room Tags or Categories (comma-separated)</label>
                <input type="text" id="roomTags" name="roomTags" placeholder="e.g., Coding, Design">
            </div>
            
            <!-- Room Image or Logo Upload Field -->
            <div class="form-group">
                <label for="roomImage">Upload Room Image or Logo</label>
                <input type="file" id="roomImage" name="roomImage" accept="image/*">
            </div>
            
            <!-- Room Type Field -->
            <div class="form-group">
                <label for="roomType">Room Type</label>
                <select id="roomType" name="roomType">
                    <option value="oneTime">One-Time Event</option>
                    <option value="recurring">Recurring Sessions</option>
                    <option value="ongoing">Ongoing Discussion</option>
                </select>
            </div>
            
            <!-- Access Code or Password Field (if room is private) -->
            <div class="form-group">
                <label for="roomPassword">Access Code or Password (if private)</label>
                <input type="password" id="roomPassword" name="roomPassword">
            </div>
            
            <!-- Moderator or Host Field -->
            <div class="form-group">
                <label for="roomHost">Moderator or Host (optional)</label>
                <input type="text" id="roomHost" name="roomHost" placeholder="Enter username">
            </div>
            
            <!-- Pre-requisites Field -->
            <div class="form-group">
                <label for="roomPrerequisites">Pre-requisites or Requirements</label>
                <textarea id="roomPrerequisites" name="roomPrerequisites" rows="4" placeholder="Enter any pre-requisites or requirements"></textarea>
            </div>
            
            <!-- Communication Preferences Field -->
            <div class="form-group">
                <label for="communicationPreferences">Communication Preferences</label>
                <select id="communicationPreferences" name="communicationPreferences">
                    <option value="textChat">Text Chat Only</option>
                    <option value="videoCalls">Video Calls</option>
                    <option value="combination">Text Chat and Video Calls</option>
                </select>
            </div>

            <button type="submit" class="cta-button">Create Room</button>
        </form>
    </div>
    <hr>
@endsection
