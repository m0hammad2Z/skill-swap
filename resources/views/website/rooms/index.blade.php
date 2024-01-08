
@extends('website.layouts.app')

<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Find a Room | SkillSwap')</title>
    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/rooms.css') }}">
    @endsection
    
</head>
<body>
   
    @section('content')
    <div class="cards-container">    
        <div class="left">
            <h1 class="section-title">Find a Room</h1>
            <div class="cards">

                @foreach($rooms as $room)
                    
                    <div class="card">
                        <div class="card-header" style="background-image: url('{{asset('storage/'.$room->image)}}');">
                            <h2 class="card-title">{{ $room->name }}</h2>
                            <p class="card-description">{{ $room->description }}</p>   
                        </div>
                        <div class="creator-info">
                            <p>Created by: {{ $room->user->first_name }}</p>
                            <p>Skill to Teach: {{ $room->skill_to_teach->name }}</p>
                            <p>Wants to Learn: {{ $room->skill_to_learn->name }}</p>
                            <p>Number of Participants: {{ $room->membersCount }}</p>
                            <p>Rating: 4.5/5</p>
                        </div>
        
                        <a href="/room/1" class="cta-button btn">Join Room</a>
                    </div>
                
                @endforeach

            </div>
        </div>

        <div class="right">
            <!-- Search Bar -->
            <div class="sub-section-title">
                <h2>Search</h2>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search by skill or room title">
                {{-- <button class="btn">Search</button> --}}
            </div>

            <!-- Filter -->
            <div class="filter">
                <h2 class="filter-title">Filter</h2>
                <div class="filter-content">
                    <div class="filter-section">
                        <div class="filter-section-content">
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill1">
                                <label for="skill1">HTML</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill2">
                                <label for="skill2">CSS</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill3">
                                <label for="skill3">JavaScript</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill4">
                                <label for="skill4">Python</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill5">
                                <label for="skill5">Java</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill6">
                                <label for="skill6">C++</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill7">
                                <label for="skill7">C#</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill8">
                                <label for="skill8">PHP</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill9">
                                <label for="skill9">SQL</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill10">
                                <label for="skill10">Swift</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill11">
                                <label for="skill11">Kotlin</label>
                            </div>
                            <div class="filter-option">
                                <input type="checkbox" name="skill" id="skill12">
                                <label for="skill12">Ruby</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <hr>   
    @endsection



</body>
</html>

