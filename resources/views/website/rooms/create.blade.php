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


@section('content')
    <h1 class="section-title">Create a Room</h1>
    <p class="subtitle">Fill out the form below to create a room.</p>

    {{-- Display errors --}}
    
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>        
    @endforeach

    <div class="form-container">
        <form action="{{ route('rooms.create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Room Name Field -->
            <div class="form-group">
                <label for="name">Room Name</label>
                <input type="text" id="name" name="name" placeholder="Enter room name" required>
            </div>

            <!-- Room Description Field -->
            <div class="form-group">
                <label for="description">Room Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter room description"></textarea>
            </div>

            <!-- Room Skill to Learn Field -->
            <div class="form-group skill_to_learn_id">
                <label for="skill_to_learn_id">Skill to Learn</label>
                <select id="skill_to_learn_id" name="skill_to_learn_id" required>
                    @foreach($skills as $skill)
                        @if(!$userSkills->contains($skill->id))
                            <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Room skill to teach --}}

            <div class="form-group skill_to_teach_id">
                <label for="skill_to_teach_id">Skill to Teach</label>
                <select id="skill_to_teach_id" name="skill_to_teach_id">
                    @foreach($userSkills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- max_participants --}}
            <div class="form-group">
                <label for="max_participants">Maximum Participants</label>
                <input type="number" id="max_participants" name="max_participants" min="2" max="10" value="2" onchange="calculateCost()" >
            </div>

            {{-- room_ image--}}
            <div class="form-group">
                <label for="image">Upload Room Image or Logo</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>

            {{-- requrments --}}
            <div class="form-group">
                <label for="requirements">Requirements</label>
                <textarea id="requirements" name="requirements" rows="4" placeholder="Enter room requirements"></textarea>
            </div>

            {{-- learnign outcomes --}}
            <div class="form-group">
                <label for="learning_outcomes">Learning Outcomes</label>
                <textarea id="learning_outcomes" name="learning_outcomes" rows="4" placeholder="Enter room learning outcomes"></textarea>
            </div>

            {{-- is resource enabled --}}
            <div class="form-group">
                <label for="is_resource_enabled">Is Resource Enabled</label>
                <input type="checkbox" id="is_resource_enabled" name="is_resource_enabled" value="1" onchange="calculateCost()">
            </div>

            {{-- is private --}}
            <div class="form-group">
                <label for="is_private">Is Private</label>
                <input type="checkbox" id="is_private" name="is_private" value="1" onchange="calculateCost()">
            </div>

            {{-- access code --}}
            <div class="form-group">
                <label for="access_code">Access Code or Password</label>
                <input type="password" id="access_code" name="access_code">
            </div>

            {{-- is_featured --}}
            <div class="form-group">
                <label for="is_featured">Is Featured</label>
                <input type="checkbox" id="is_featured" name="is_featured" value="1" onchange="calculateCost()">
            </div>

            {{-- feattured_until --}}
            <div class="form-group">
                <label for="featured_until">Featured Until (In Hours)</label>
                <input type="number" placeholder="Enter number of hours" id="featured_until" name="featured_until" onchange="calculateCost()" value="1" min="1">
            </div>

            {{-- creation cost --}}
            <div class="form-group">
                <output id="creation_cost" name="creation_cost" value="0">
                    <label for="creation_cost">Creation Cost</label>
                </output>
                    
            </div>
            
            <button type="submit" class="cta-button">Create Room</button>
        </form>
    </div>
    <hr>

    <script>

        window.onload = function() {
            checkPrivate();
            checkFeatured();

            calculateCost();
        };
        
        document.getElementById('is_private').addEventListener('change', checkPrivate);

        document.getElementById('is_featured').addEventListener('change', checkFeatured);


        function checkPrivate(){
            let accessCodeParent = document.getElementById('access_code').parentElement;
            let featuredUntilParent = document.getElementById('featured_until').parentElement;
            let isFeatured = document.getElementById('is_featured');


            if (this.checked) {
                accessCodeParent.style.display = 'block';
                featuredUntilParent.style.display = 'none';
                isFeatured.parentElement.style.display = 'none';
                isFeatured.checked = false;
            } else {
                accessCodeParent.style.display = 'none';
                isFeatured.parentElement.style.display = 'block';
            }  
        }
        function checkFeatured(){
            let featuredUntilParent = document.getElementById('featured_until').parentElement;

            if (this.checked) {
                featuredUntilParent.style.display = 'block';
            } else {
                featuredUntilParent.style.display = 'none';
            }  
        }


        // participants cost calculation
        // particpants free,  if > 4 then 5 coins per participant
        // if private then 10 coins
        // if featured then 2 coins per hour
        // if resource enabled then 10 coins
        function calculateCost(){
            let maxParticipants = document.getElementById('max_participants').value;
            let isPrivate = document.getElementById('is_private').checked;
            let isFeatured = document.getElementById('is_featured').checked;
            let isResourceEnabled = document.getElementById('is_resource_enabled').checked;
            let featuredUntil = document.getElementById('featured_until').value;
           
            let creationCost = 0;

            if (maxParticipants > 4) {
                creationCost += (maxParticipants - 4) * 5;
            }

            if (isPrivate) {
                creationCost += 10;
            }

            // In hours
            if (isFeatured && !isPrivate) {
                creationCost += featuredUntil * 2;
            }

            if (isResourceEnabled) {
                creationCost += 10;
            }

            document.getElementById('creation_cost').value = creationCost;
            document.getElementById('creation_cost').innerHTML = creationCost + ' <i class="fas fa-coins" style="font-size: 1em;"></i>';
        }

        


    </script>
    

@endsection
