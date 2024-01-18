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
        toastNotification('{{ session('status') }}', 'success', 3000);
    @endif
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sockjs-client/1.5.1/sockjs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/stomp.js/2.3.3/stomp.min.js"></script>

@if ((!$room->isMember))

    @if($room->is_private)
        @if($room->members->count() >= $room->max_attendees)
            <script>
                toastNotification('This room is full, you will be redirected to the rooms page', 'error', 3000);
                window.location.href = "/rooms";
            </script>
        @else
            <script>
                prompt('This room is private, please enter the password to join');
            </script>
        @endif
    @endif
    <script>
        window.location.href = "/rooms";
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

            @if($room->video_sessions->count() == 0)
                <div class="empty" style="text-align: center; margin: 8em auto;">
                    <i class="fas fa-video" style="font-size: 9em;"></i>
                    <h1>No sessions yet</h1>
                    <p>Once you create a session, it will appear here</p>
                </div>
            @else
    
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

            @endif
        </div>
    
        <!-- Chat Section -->
        <div id="chatSection" class="room-section">      
            <div class="top-content">
                <h2>Chat</h2>
            </div>
            
            <div class="chat-container">

            </div>
            <div class="message-input-container">
                <input type="text" placeholder="Type your message here...">
                <button ><i class="fas fa-paper-plane"></i></button>
            </div>

        </div>
    
        <!-- Resources Section -->
        @if ($room->is_resources_provided)
            
            <div id="resourcesSection" class="room-section">
                <div class="top-content">
                    <h2>Resources</h2>
                    <button id="resourceBtn" class="cta-button" onclick="openAddResourceModal()">Add New Resource</button>
                </div>
            
                <div class="resources-container">     
                    @if($room->resources->count() == 0)
                        <div class="empty" style="text-align: center; margin: 8em auto;">
                            <i class="fas fa-file" style="font-size: 9em;"></i>
                            <h1>No resources yet</h1>
                            <p>Once you add a resource, it will appear here</p>
                        </div>
                    @else
                    
                        <div id="resourceList">
                            <h3>Shared Resources</h3>
                            
                            <div class="vcard table-titles">
                                <strong>Made By</strong>
                                <strong>Resource Name</strong>
                                <strong>Resource Type</strong>
                                <strong>Resource Link</strong>
                                <strong>Actions</strong>

                            </div>

                            @foreach ($room->resources as $resource)
                                <div class="vcard" id="resource{{ $resource->id }}">
                                    <p>{{ $room->members->where('id', $resource->user_id)->first()->username }}</p>
                                    <p>{{ $resource->description }}</p>
                                    <p>{{ $resource->resource_type }}</p>
                                    <p>{{ $resource->resource_url }}</p>
                                    @if(Auth::user()->id == $resource->user_id)
                                        <div class="actions">
                                            <a href="#" onclick="deleteResource('{{ $resource->id }}')"><i class="fas fa-trash-alt"></i></a>
                                            <a href="#" onclick="openEditResourceModal('{{ $resource->description }}', '{{ $resource->resource_url }}', '{{ $resource->resource_type }}' , '{{ $resource->id }}')"><i class="fas fa-edit"></i></a>
                                            <a href="{{ $resource->resource_url }}" target="_blank"><i class="fas fa-eye"></i></a>
                                        </div>
                                    @else
                                        <div class="actions">
                                            <a href="{{ $resource->resource_url }}" target="_blank"><i class="fas fa-eye"></i></a>
                                        </div>
                                    @endif
                                </div>
                            
                            @endforeach
                        </div>
                    @endif
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
                                <button class="red-button">Kick</button>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="room-actions">
                    @if (Auth::user()->id == $room->user->id)
                        <button class="delete-button red-button" onclick="deleteRoom()">Delete Room</button>
                    @endif
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
            <form>
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <label for="resourceName">Resource Name</label>
                <input type="text" id="resourceName" name="resourceName" required>
                <label for="resourceLink">Resource Link</label>
                <input type="text" id="resourceLink" name="resourceLink" required>
                <label for="resourceType">Resource Type</label>
                <select name="resourceType" id="resourceType">
                    <option value="video">Video</option>
                    <option value="image">Image</option>
                    <option value="file">File</option>
                </select>
                <button type="submit" class="cta-button" onclick="addResource()">Add</button>
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
            <form>
                <input type="hidden" id="resource_id" name="resource_id">
                <label for="updateResourceName">Resource Name</label>
                <input type="text" id="updateResourceName" name="resourceName" required>
                <label for="updateResourceLink">Resource Link</label>
                <input type="text" id="updateResourceLink" name="resourceLink" required>
                <label for="updateResourceType">Resource Type</label>
                <select name="resourceType" id="updateResourceType">
                    <option value="video">Video</option>
                    <option value="image">Image</option>
                    <option value="file">File</option>
                </select>
                <button type="submit" class="cta-button" onclick="editResource()">Edit</button>
            </form>
        </div>
    </div>
</div>

<script>
    let url = new URL(window.location.href);
    let section = url.searchParams.get("section");
    if(section != null){
        showSection(section);
    } else {
    showSection('videoSection');
    }
    
    function showSection(sectionId) {
        const sections = document.getElementsByClassName('room-section');
        for (const section of sections) {
            section.style.display = 'none';
        }

        document.getElementById(sectionId).style.display = 'block';     

        //Store the section as get parameter in the url
        window.history.replaceState({}, '', `?section=${sectionId}`);
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
    function joinVideoSession($link){
        confirmModal('Join Video Session', 'Are you sure you want to join this video session?', 'warning', 'Yes', 'No').then((result) => {
            if (result.isConfirmed) {
                window.open($link, '_blank')
            }
        });
    }

    
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
    function openEditResourceModal(name, link, type, resource_id){
        event.preventDefault();
        document.getElementById('updateResourceName').value = name;
        document.getElementById('updateResourceLink').value = link;
        document.getElementById('updateResourceType').value = type;
        document.getElementById('resource_id').value = resource_id;
        document.getElementById('editResourcemodal').style.display = 'block';
    }

    function closeEditResourceModal(){
        document.getElementById('editResourcemodal').style.display = 'none';
    }

</script>

{{-- Resources requests --}}
<script>
        // Add resource 
        async function addResource() {
            event.preventDefault(); 
            
            let description = document.getElementById('resourceName').value;
            let link = document.getElementById('resourceLink').value;
            let type = document.getElementById('resourceType').value;
            
            if(description == '' || link == '' || type == ''){
                toastNotification('Please fill all the fields', 'error', 3000);
                return;
            }
            
            const sweetModal = await confirmModal('Add Resource', 'Are you sure you want to add this resource?', 'warning', 'Yes', 'No');
            if (sweetModal.isConfirmed) {
                loadingElement('Adding Resource...');
                const response = await addResourceRequest();
                if (response.success) {
                    toastNotification(response.message, 'success', 3000);
                    addCard('{{ Auth::user()->username }}', description, type, link, "<a href='#'><i class='fas fa-trash-alt'></i></a><a href='#' onclick='openEditResourceModal()'><i class='fas fa-edit'></i></a><a href='#' target='_blank'><i class='fas fa-eye'></i></a>");
                    closeAddResourceModal();
                } else {
                    toastNotification(response.message, 'error', 3000); 
                }
            }
    }

    async function addResourceRequest() {
        try{
            const reponse = await fetch('{{ route('resources.store')}}',
                {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        resourceName: document.getElementById('resourceName').value,
                        resourceLink: document.getElementById('resourceLink').value,
                        resourceType: document.getElementById('resourceType').value,
                        room_id: {{ $room->id }},
                        user_id: {{ Auth::user()->id }}
                    })
                });

            const data = await reponse.json();

            return {
                success: data.success,
                message: data.message
            };

        } catch (error) {
            return {
                success: false,
                message: error
            };
        }
    }

    function addCard(madyBy, resourceName, resoureceType, link, actions){
        let card = document.createElement('div');
        card.classList.add('vcard');
        card.innerHTML = `
            <p>${madyBy}</p>
            <p>${resourceName}</p>
            <p>${resoureceType}</p>
            <p>${link}</p>
            <div class="actions">
                ${actions}
            </div>
        `;
        document.getElementById('resourceList').appendChild(card);
    }

    // Edit resource
    async function editResource() {
        event.preventDefault(); 
        
        let description = document.getElementById('updateResourceName').value;
        let link = document.getElementById('updateResourceLink').value;
        let type = document.getElementById('updateResourceType').value;
        let resource_id = document.getElementById('resource_id').value;
        let actions =``;

        actions = `<a href="#"><i class="fas fa-trash-alt"></i></a>
                    <a href="#" onclick="openEditResourceModal('${description}', '${link}', '${type}', '${resource_id}')"><i class="fas fa-edit"></i></a>
                    <a href="${link}" target="_blank"><i class="fas fa-eye"></i></a>`;

        if(description == '' || link == '' || type == ''){
            toastNotification('Please fill all the fields', 'error', 3000);
            return;
        }
        
        const sweetModal = await confirmModal('Edit Resource', 'Are you sure you want to edit this resource?', 'warning', 'Yes', 'No');
        if (sweetModal.isConfirmed) {
            loadingElement('Editing Resource...');
            const response = await editResourceRequest();
            if (response.success) {
                toastNotification(response.message, 'success', 3000);

                editCard('{{ Auth::user()->username }}', description, type, link, actions, resource_id);
                closeEditResourceModal();
            } else {
                toastNotification(response.message, 'error', 3000); 
            }
        }
    }

    async function editResourceRequest(){
        try{
            const reponse = await fetch('{{ route('resources.update')}}',
                {
                    method: 'PATCH',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        resourceName: document.getElementById('updateResourceName').value,
                        resourceLink: document.getElementById('updateResourceLink').value,
                        resourceType: document.getElementById('updateResourceType').value,
                        resource_id: document.getElementById('resource_id').value
                    })
                });

            const data = await reponse.json();

            return {
                success: data.success,
                message: data.message
            };

        } catch (error) {
            return {
                success: false,
                message: error
            };
        }
    }

    function editCard(madyBy, resourceName, resoureceType, link, actions, resource_id){
        let card = document.getElementById('resource' + resource_id);
        card.innerHTML = `
            <p>${madyBy}</p>
            <p>${resourceName}</p>
            <p>${resoureceType}</p>
            <p>${link}</p>
            <div class="actions">
                ${actions}
            </div>
        `;
    }


    // Delete resource
    async function deleteResource(resource_id) {
        event.preventDefault();
        const sweetModal = await confirmModal('Delete Resource', 'Are you sure you want to delete this resource?', 'warning', 'Yes', 'No');
        if (sweetModal.isConfirmed) {
            loadingElement('Deleting Resource...');
            const response = await deleteResourceRequest(resource_id);
            
            if (response.success) {
                toastNotification(response.message, 'success', 3000);
                document.getElementById('resource' + resource_id).remove();
            } else {
                toastNotification(response.message, 'error', 3000); 
            }
        }
    }

    async function deleteResourceRequest(resource_id){
        try{
            const reponse = await fetch('{{ route('resources.destroy')}}',
                {
                    method: 'DELETE',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        resource_id: resource_id
                    })
                });

            const data = await reponse.json();

            return {
                success: data.success,
                message: data.message
            };

        } catch (error) {
            return {
                success: false,
                message: 'Something went wrong,  please try again later'
            };
        }
    }


    function deleteCard(resource_id){
        document.getElementById('resource' + resource_id).remove();
    }

</script>


{{-- Chat  --}}
<script>
    // UI
    const chatContainer = document.querySelector('.chat-container');
    const messageInput = document.querySelector('.message-input-container input');
    const messageBtn = document.querySelector('.message-input-container button');

    messageBtn.addEventListener('click', (e) => {
        if(messageInput.value != ''){
            sendMessage(messageInput.value);
            messageInput.value = '';
        }else{
            toastNotification('Please type a message', 'error', 3000);
        }
    });

    // on enter key press
    messageInput.addEventListener('keyup', (e) => {
        if(e.keyCode === 13){
            if(messageInput.value != ''){
                sendMessage(messageInput.value);
                messageInput.value = '';
            }else{
                toastNotification('Please type a message', 'error', 3000);
            }
        }
    });

    function sentMessage(message, time, userImage){
        let messageDiv = document.createElement('div');
        messageDiv.classList.add('sent-message', 'message');
        messageDiv.innerHTML = `
        <div class="message-user-image">
            <span class="message-time" style="font-size: 0.6em; text-align: center;">${time}</span>
            <img src="${userImage}" alt="user image">
            <span style="font-size: 0.8em; text-align: center;"> mohammad </span>
        </div>
        <p >${message}</p>
        `;
        chatContainer.appendChild(messageDiv);
    }

    function receivedMessage(message, time, userImage, username){
        let messageDiv = document.createElement('div');
        messageDiv.classList.add('received-message', 'message');
        messageDiv.innerHTML =  ` <div class="message-user-image">
            <span class="message-time" style="font-size: 0.6em; text-align: center;">${time}</span>
            <img src="${userImage}" alt="user image">
            <span style="font-size: 0.8em; text-align: center;"> ${username} </span>
        </div>
        <p>${message}</p>
        `;
        chatContainer.appendChild(messageDiv);
    }




    // Chat
    const socket = new SockJS('http://localhost:8080/chat');
    const stompClient = Stomp.over(socket);

    const userId = '{{ Auth::user()->id }}';
    const roomId = '{{ $room->id }}';

    let loaded = false;

    stompClient.connect({}, (frame) => {
        

        stompClient.send("/app/getPreviousMessages/" + roomId);
        

        stompClient.subscribe(`/topic/messages/${roomId}`, function (message) {
            const messageData = JSON.parse(message.body);

            let members = []

            @foreach ($room->members as $member)
                members.push(
                    {
                        id: '{{ $member->id }}',
                        username: '{{ $member->username }}',
                        profile_picture: '{{ $member->profile_picture }}'
                    }
                );
            @endforeach


            if(Array.isArray(messageData)){
                if (!loaded)
                for (let i = 0; i < messageData.length; i++) {
                    const time = new Date(messageData[i].timestamp);
                    messageData[i].timestamp = time.toLocaleString('en-GB', {weekday: 'short', day: 'numeric', month: 'numeric', hour: 'numeric', minute: 'numeric'});

                    const member = members.find(member => member.id == messageData[i].userId);
                    if(messageData[i].userId == userId){
                        sentMessage(messageData[i].content, messageData[i].timestamp, '../storage/' + member.profile_picture, member.username);
                    } else {
                        receivedMessage(messageData[i].content, messageData[i].timestamp, '../storage/' + member.profile_picture, member.username);
                    }
                }

                loaded = true;
            } else {
                const time = new Date(messageData.timestamp);
                messageData.timestamp = time.toLocaleString('en-GB', {weekday: 'short', day: 'numeric', month: 'numeric', hour: 'numeric', minute: 'numeric'});
                const member = members.find(member => member.id == messageData.userId);

                if(messageData.userId == userId){
                    sentMessage(messageData.content, messageData.timestamp, '../storage/' + member.profile_picture, member.username);
                } else {
                    receivedMessage(messageData.content, messageData.timestamp, '../storage/' + member.profile_picture, member.username);
                }
            }

            //scroll to bottom of chat-container
            chatContainer.scrollTop = chatContainer.scrollHeight;


        });
    });

    function sendMessage(content) {
            const message = {
            userId: userId,
            content: content
        };

        // Send the message to the server
        stompClient.send("/app/chat/" + roomId, {}, JSON.stringify(message));  
    }

</script>





@endsection

