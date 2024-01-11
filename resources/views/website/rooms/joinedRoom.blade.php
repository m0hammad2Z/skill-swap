@extends('website.layouts.app')

@section('title', 'Room Example')



@section('styles')
    <link rel="stylesheet" href="{{ asset('css/myroomDetails.css') }}">
@endsection


@section('content')

<script>
    @foreach ($errors->all() as $error)
        toastNotification('{{ $error }}', 'error', 3000);
    @endforeach

    @if (session('status'))
        toastNotification('{{ session('status') }}', 'success',  3000);
    @endif
</script>


@if ((!$room->isMember && !$room->is_private) || (!$room->isMemeber && $room->members->count() == $room->max_attendees))
    <script>
        window.location.href = "/rooms";
    </script>
@elseif (!$room->isMember && $room->is_private)
    <script>
        pomote("Insert the code to join this room")
    </script>
@endif

<div class="container">
    <div class="top">
        
        <h1 class="section-title">{{ $room->name }}</h1>
        <div id="roomButtons">
            <button onclick="showSection('videoSection')">Video</button>
            <button onclick="showSection('chatSection')">Chat</button>
            @if ($room->is_resources_provided)
                <button onclick="showSection('resourcesSection')">Resources</button>
            @endif
            <button onclick="showSection('settingsSection')">Settings</button>
        </div>
    </div>
    

    <div id="roomSections">
        <!-- Video Section -->
        <div id="videoSection" class="room-section">
            <div class="top-content">
                <h2>Video</h2>
                <div>
                    <button id="sessionBtn" class="cta-button" onclick="openCreateSessionModal()">Create Session</button>      
                    @if($room->video_sessions->count() > 0 && $room->video_sessions->last()->created_at->addDays(7) > now())
                        <button id="joinSessionBtn" class="cta-button" onclick="joinVideoSession('{{ $room->video_sessions->last()->api_session_id }}')">Join Session</button> 
                    @endif

                </div>
            </div>
    
            <div class="sessions-container">
                <div id="pastSessions">
                    <h3>Past Sessions</h3>

                    <div class="vcard table-titles">
                        <strong>Room</strong>
                        <strong>From</strong>
                        <strong>To</strong>
                        <strong >Rating</strong>
                    </div>
                    
                    @foreach($room->video_sessions as $session)    

                        <div class="vcard">
                            <p>{{ $session->name }}</p>
                            <p>{{ $session->created_at }}</p>
                            <p>  {{ $session->created_at->addDays(7)}}</p>
                            <div class="rating-section">
                                <div class="star" onclick="starsRating(1)">
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1"> <i class="fas fa-star"></i></label>
                                </div>
                                <div class="star" onclick="starsRating(2)">
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2"> <i class="fas fa-star"></i></label>
                                </div>
                                <div class="star" onclick="starsRating(3)">
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3"> <i class="fas fa-star"></i></label>
                                </div>
                                <div class="star"   onclick="starsRating(4)">
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4"> <i class="fas fa-star"></i></label>
                                </div>
                                <div class="star" onclick="starsRating(5)">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5"> <i class="fas fa-star"></i></label>
                                </div>       
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    
        <!-- Chat Section -->
        <div id="chatSection" class="room-section">      
            <div class="top-content">
                <h2>Chat</h2>
            </div>
            
            <div class="chat-container">
                <div class="sent-message message">
                    <img src="https://th.bing.com/th/id/OIP.Smc-fqLOF6l7eou3U5x-pwAAAA?rs=1&pid=ImgDetMain" alt="user image">
                    <p>Message Sent by the other dsadas dsds dsads other dsadas dsds dsads other dsadas dsds dsads other dsadas dsds dsads other dsadas dsds dsads</p>
                </div>
                <div class="received-message message">
                    <img src="https://external-preview.redd.it/pHyoLgqrcqZA_iM7E6EaBvAryOnUg7hYqDi0hGXi1R4.jpg?auto=webp&s=ec77bbe59df8e9e84e079d3c2a99782a69f5a008" alt="user image">
                    <p>Message sent by the user</p>
                </div>
                <div class="sent-message message">
                    <img src="https://th.bing.com/th/id/OIP.Smc-fqLOF6l7eou3U5x-pwAAAA?rs=1&pid=ImgDetMain" alt="user image">
                    <p>Message Sent by the other  dsds dsads other dsadas dsds dsads other dsadas dsds dsads</p>
                </div>
                <div class="received-message message">
                    <img src="https://external-preview.redd.it/pHyoLgqrcqZA_iM7E6EaBvAryOnUg7hYqDi0hGXi1R4.jpg?auto=webp&s=ec77bbe59df8e9e84e079d3c2a99782a69f5a008" alt="user image">
                    <p>Message sent by the user</p>
                </div>
                <div class="sent-message message">
                    <img src="https://th.bing.com/th/id/OIP.Smc-fqLOF6l7eou3U5x-pwAAAA?rs=1&pid=ImgDetMain" alt="user image">
                    <p>s other dsadas dsds dsads other dsadas dsds dsads</p>
                </div>
                <div class="received-message message">
                    <img src="https://external-preview.redd.it/pHyoLgqrcqZA_iM7E6EaBvAryOnUg7hYqDi0hGXi1R4.jpg?auto=webp&s=ec77bbe59df8e9e84e079d3c2a99782a69f5a008" alt="user image">
                    <p>Message sent by the user dsadas dsds dsads other dsadas dsds</p>
                </div>
                <div class="sent-message message">
                    <img src="https://th.bing.com/th/id/OIP.Smc-fqLOF6l7eou3U5x-pwAAAA?rs=1&pid=ImgDetMain" alt="user image">
                    <p>Message Sent by the other dsadas dsds dsads other dsadas dsds dsads other dsadas dsds dsads other dsadas dsds dsads other dsadas dsds dsads</p>
                </div>
                <div class="received-message message">
                    <img src="https://external-preview.redd.it/pHyoLgqrcqZA_iM7E6EaBvAryOnUg7hYqDi0hGXi1R4.jpg?auto=webp&s=ec77bbe59df8e9e84e079d3c2a99782a69f5a008" alt="user image">
                    <p>Message sent by the user</p>
                </div>
                <div class="sent-message message">
                    <img src="https://th.bing.com/th/id/OIP.Smc-fqLOF6l7eou3U5x-pwAAAA?rs=1&pid=ImgDetMain" alt="user image">
                    <p>Message Sent by the other  dsds dsads other dsadas dsds dsads other dsadas dsds dsads</p>
                </div>
                <div class="received-message message">
                    <img src="https://external-preview.redd.it/pHyoLgqrcqZA_iM7E6EaBvAryOnUg7hYqDi0hGXi1R4.jpg?auto=webp&s=ec77bbe59df8e9e84e079d3c2a99782a69f5a008" alt="user image">
                    <p>Message sent by the user</p>
                </div>
                <div class="sent-message message">
                    <img src="https://th.bing.com/th/id/OIP.Smc-fqLOF6l7eou3U5x-pwAAAA?rs=1&pid=ImgDetMain" alt="user image">
                    <p>s other dsadas dsds dsads other dsadas dsds dsads</p>
                </div>
                <div class="received-message message">
                    <img src="https://external-preview.redd.it/pHyoLgqrcqZA_iM7E6EaBvAryOnUg7hYqDi0hGXi1R4.jpg?auto=webp&s=ec77bbe59df8e9e84e079d3c2a99782a69f5a008" alt="user image">
                    <p>Message sent by the user dsadas dsds dsads other dsadas dsds</p>
                </div>
            </div>
            <div class="message-input-container">
                <input type="text" placeholder="Type your message here...">
                <button ><i class="fas fa-paper-plane"></i></button>
            </div>

        </div>
    
        @if ($room->is_resources_provided)
            <!-- Resources Section -->
            <div id="resourcesSection" class="room-section">
                <div class="top-content">
                    <h2>Resources</h2>
                    <button id="resourceBtn" class="cta-button" onclick="openAddResourceModal()">Add New Resource</button>
                </div>
            
                <div class="resources-container">                
                    <div id="resourceList">
                        <h3>Shared Resources</h3>
                        
                        <div class="vcard table-titles">
                            <strong>Resource Name</strong>
                            <strong>Resource Link</strong>
                            <strong>Actions</strong>
                        </div>


                        <div class="vcard">
                            <p>Resource 1</p>
                            <p>https://www.google.com/</p>
                            <div class="actions">
                                <a href="#"><i class="fas fa-trash-alt"></i></a>
                                <a href="#" onclick="openEditResourceModal()"><i class="fas fa-edit"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endif
    
        <!-- Settings Section -->
        <div id="settingsSection" class="room-section">
            <div class="top-content">
                <h2>Room Settings</h2>
            </div>

            <div class="settings-container">
                <form action="" method="post">
                    <label for="roomName">Room Name</label>
                    <input type="text" id="roomName" name="roomName" required>
                    <label for="roomDescription">Room Description</label>
                    <textarea name="roomDescription" id="roomDescription" cols="30" rows="10" required></textarea>
                    <button type="submit" class="cta-button">Save</button>
                </form>

                <div>
                    <h3>Room Members</h3>
                    <div class="members-container">
                        @foreach($room->members as $member)
                            <div class="member">
                                <p>{{ $member->username }}</p>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="room-actions">
                    <button class="delete-button red-button" onclick="deleteRoom()">Delete Room</button>
                    <button class="leave-button red-button" onclick="leaveRoom()">Leave Room</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="createSessionModal modal" id="createSessionModal">
    <div class="content">
        <div class="modal-top">
            <h2>Create Session</h2>
            <span class="close" onclick="closeCreateSessionModal()">&times;</span>
        </div>
        <div class="modal-content">
            <form method="POST" action="{{ route('videoSession.store') }}">
                @csrf
                <label for="sessionName">Session Name</label>
                <input type="text" id="sessionName" name="name" required>
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <button type="submit" class="cta-button">Create</button>
            </form>
        </div>
    </div>
</div>

<div class="addResourcemodal modal" id="addResourcemodal">
    <div class="content">
        <div class="modal-top">
            <h2>Add Resource</h2>
            <span class="close" onclick="closeAddResourceModal()">&times;</span>
        </div>
        <div class="modal-content">
            <form method="POST">
                @csrf
                <label for="resourceName">Resource Name</label>
                <input type="text" id="resourceName" name="resourceName" required>
                <label for="resourceLink">Resource Link</label>
                <input type="text" id="resourceLink" name="resourceLink" required>
                <button type="submit" class="cta-button">Add</button>
            </form>
        </div>
    </div>
</div>

<div class="editResourcemodal modal" id="editResourcemodal">
    <div class="content">
        <div class="modal-top">
            <h2>Edit Resource</h2>
            <span class="close" onclick="closeEditResourceModal()">&times;</span>
        </div>
        <div class="modal-content">
            <form method="POST">
                @csrf
                <label for="resourceName">Resource Name</label>
                <input type="text" id="resourceName" name="resourceName" required>
                <label for="resourceLink">Resource Link</label>
                <input type="text" id="resourceLink" name="resourceLink" required>
                <button type="submit" class="cta-button">Edit</button>
            </form>
        </div>
    </div>
</div>

<script>
    showSection('videoSection');
    function showSection(sectionId) {
        // Hide all sections
        const sections = document.getElementsByClassName('room-section');
        for (const section of sections) {
            section.style.display = 'none';
        }

        // Show the selected section
        document.getElementById(sectionId).style.display = 'block';        
    }

    closeCreateSessionModal();

    function openCreateSessionModal(){
        document.getElementById('createSessionModal').style.display = 'block';
    }
    function closeCreateSessionModal(){
        document.getElementById('createSessionModal').style.display = 'none';
    }
    
    function starsRating(rating) {
        const stars = document.getElementsByClassName('fa-star');
        const starsRating = document.getElementById('starsRating');
        for (let star of stars){
            star.style.color = 'var(--light-color)';
        }
        for (let i = 0; i < rating; i++) {
            stars[i].style.color = 'gold';
        }
    }


    // Confirm modla to join a video session

    
    </script>
<hr>

<script>
    // RESOURCE MODAL
    closeAddResourceModal();
    function openAddResourceModal(){
        document.getElementById('addResourcemodal').style.display = 'block';
    }

    function closeAddResourceModal(){
        document.getElementById('addResourcemodal').style.display = 'none';
    }

    // EDIT RESOURCE MODAL
    closeEditResourceModal();
    function openEditResourceModal(){
        document.getElementById('editResourcemodal').style.display = 'block';
    }

    function closeEditResourceModal(){
        document.getElementById('editResourcemodal').style.display = 'none';
    }

</script>

<script>
    // async function makeSessionRequest(){
    //     let request = await fetch('{{ route('videoSession.store') }}',
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'Accept': 'application/json',
    //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //     },
    //     body: JSON.stringify({
    //         name: document.getElementById('sessionName').value,
    //         room_id: {{ $room->id }}
    //     }));

    //     let response = await request.json();
    //     if (response.status === 'success') {
    //         toastNoftification('Session created successfully', 'success');
    //     }
    // }
    
    function joinVideoSession($link){
        confirmModal('Join Video Session', 'Are you sure you want to join this video session?', 'warning', 'Yes', 'No').then((result) => {
            if (result.isConfirmed) {
                window.open($link, '_blank')
            }
        });
    }
    
</script>

@endsection

