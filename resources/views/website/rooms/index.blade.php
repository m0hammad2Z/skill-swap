
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
        <h1 class="section-title">Find a Room</h1>
        <div class="search-bar" style="margin-bottom: 2em; width: 100%;">
            <input type="text" placeholder="Search by skill or room title">
        </div>  
        <div class="left">
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
        
                        <a href="/rooms/{{ $room->id }}" class="cta-button btn">Join Room</a>
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
            if(rooms.data.length == 0){
                cards.innerHTML = "<h1>No results found</h1>";
            }else
            {
                
                for(let room of rooms.data){
                    let id = 23121231;
                    cards.innerHTML += `
                    <div class="card">
                        <div class="card-header" style="background-image: url('storage/${room.image}');">
                            <h2 class="card-title">${room.name}
                            <p class="card-description">${room.description} </p>
                        </div>
                        <div class="creator-info">
                            <p>Created by: ${room.user.first_name}</p>
                            <p>Skill to Teach: ${room.skill_to_teach.name}</p>
                            <p>Wants to Learn: ${room.skill_to_learn.name}</p>
                            <p>Number of Participants: ${room.membersCount}</p>
                        </div>
        
                        <a href="/rooms/${room.id}" class="cta-button btn">Join Room</a>
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


    </script>

@endsection

</body>
</html>

