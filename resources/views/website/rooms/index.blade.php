
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
    <h1 class="section-title">Find a Room</h1>
    <div class="search-bar" style="margin-bottom: 2em; width: 100%;">
        <input type="text" placeholder="Search by skill or room title">
    </div> 

    <div class="search-suggestions">
            <span class="suggestion-item">Web Development</span>
            <span class="suggestion-item">Graphic Design</span>
            <span class="suggestion-item">Photography</span>
            <span class="suggestion-item">Video Editing</span>  
            <span class="suggestion-item">Music Production</span>
            <span class="suggestion-item">Drawing</span>
            <span class="suggestion-item">Painting</span>
            <span class="suggestion-item">Singing</span>
    </div>

    <div class="cards-container">    
 
        <div class="left">
            <div class="cards">
                @foreach($rooms as $room)
                    <div class="card">
                        <div class="card-image">
                            <img src="{{ asset('storage/'.$room->image) }}" alt="">
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>{{ $room->name }}</h2>
                                </div>
                                <div class="room-card-tags">
                                    <span class="room-card-tag">{{ $room->skill_to_learn->name }}</span>
                                    <span class="room-card-tag">{{ $room->skill_to_teach->name }}</span>
                                </div>
                                <p>{{ $room->description }}</p>
                            </div>
                            <div class="card-footer">
                                <div class="card-creator">
                                    <img src="{{ asset('storage/'.$room->user->profile_picture) }}" alt=""><span>{{ $room->user->username }}</span>
                                </div>
                                <a href="/rooms/{{ $room->id }}" class="cta-button btn">Join Room</a>
                            </div>
                        </div>
                    </div>
                
                @endforeach

            </div>
        </div>
    </div>
    
    <hr>   
    
    {{-- search --}}
    <script>
        const searchBar = document.querySelector(".search-bar input");
        const cards = document.querySelector(".cards");

        searchBar.addEventListener("keyup", async (e) => {
            const searchString = e.target.value;
            const rooms = await searchRequest(searchString);
            cards.innerHTML = "";
            console.log(rooms.success);
            if(rooms.success == false){
                cards.innerHTML = `
                <div class="empty" style="text-align: center; margin: 8em auto;">
                    <i class="fas fa-search" style="font-size: 9em;"></i>
                    <h1>No rooms found</h1>
                    <p>Try searching for something else</p>
                </div>
                `;
            }else
            {
            for(let room of rooms.data){
                cards.innerHTML += `
                <div class="card">
                    <div class="card-image">
                        <img src="storage/${room.image}" alt="">
                    </div>
                    <div class="card-content">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>${room.name}</h2>
                            </div>
                            <div class="room-card-tags">
                                <span class="room-card-tag">${room.skill_to_learn.name}</span>
                                <span class="room-card-tag">${room.skill_to_teach.name}</span>
                            </div>
                            <p>${room.description}</p>
                        </div>
                        <div class="card-footer">
                            <div class="card-creator">
                                <img src="storage/${room.user.profile_picture}" alt=""><span>${room.user.username}</span>
                            </div>
                            <a href="/rooms/${room.id}" class="cta-button btn">Join Room</a>
                        </div>
                    </div>
                </div>
                `;
            }
        }
        });
        

        async function searchRequest(string){
            try {
                const response = await fetch('{{ route('rooms.search') }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        string: string
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await response.json();
                
                return data;
            } catch (error) {
                
            }
        }

        const url = new URL(window.location.href);
        console.log("Current URL:", url.href);

        const urlParams = new URLSearchParams(url.search);
        console.log("URL Params:", urlParams);

        const searchParam = urlParams.get('search');
        console.log("Search Param:", searchParam);
        if(searchParam){
            searchBar.value = searchParam;
            searchBar.dispatchEvent(new KeyboardEvent('keyup', {'key': 'Enter'}));
        }


        suggestionItems = document.querySelectorAll(".suggestion-item");
        suggestionItems.forEach(item => {
            item.addEventListener("click", () => {
                searchBar.value = item.innerHTML;
                searchBar.dispatchEvent(new KeyboardEvent('keyup', {'key': 'Enter'}));
            });
        });


    </script>

@endsection

</body>
</html>

