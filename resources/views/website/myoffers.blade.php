@extends('website.layouts.app')

@section('title', 'Offers by me')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endsection


@section('content')

<div class="container">
    <div id="resourceList">
        <h1 class="section-title">My Offers</h1>
        <h1 class="subtitle">Here you can see all the offers you have sent</h1>
        @if ($offers->count() == 0)
            <div class="empty" style="text-align: center; margin: 8em auto;">
                <i class="fas fa-envelope" style="font-size: 9em;"></i>
                <h1>No offers yet</h1>
                <p>Once you send an offer, it will appear here</p>
            </div>
        @else
             <div class="table-titles vcard">
                <strong>Room</strong>
                <strong>Date</strong>
                <strong>Action</strong>
            </div>

            @foreach ($offers as $offer)
                <div class="vcard" id="offer-{{ $offer->id }}">
                    <div class="vcard-title">
                        <h4>{{ $offer->name }}</h4>
                    </div>
                    <div class="vcard__content">
                        <p>{{ $offer->booked_at }}</p>
                    </div>
                    <div class="vcard__content" id="status-{{ $offer->id }}">
                        <p>{{ $offer->status }}</p>
                    </div>

                    <div class="action">
                        @if ($offer->status == 'pending')
                        
                            <button class="red-button" id="cancel-btn-{{ $offer->id }}" onclick='cancelOffer({{ $offer->id }})'>Cancel</button>
                        
                        @elseif ($offer->status == 'approved')
                            <button class="cta-button" onclick="window.location.href='/myrooms/{{ $offer->room_id }}'">Room</button>
                        @else
                            <button class="cta-button" onclick="window.location.href='/rooms'">Find a room</button>
                        @endif
                     </div>

                </div>
            @endforeach
        @endif
    </div>
</div>

<script>

   async function cancelOffer(id){
    
        let cancelBtn = this;
        let status = document.getElementById(`status-${id}`);

        let parentElement = document.getElementById(`offer-${id}`);

        const sweetAlert = await confirmModal('Are you sure you want to cancel this offer?', 'This action cannot be undone', 'warning', 'Yes, cancel it', 'No, keep it');

        if(sweetAlert.isConfirmed) {
            loadingElement('Deleteing...');
            const response = await request(id,' {{ route('bookings.cancel')}}' );
            const { success, message } = response;

            if(success) {
                const status = document.getElementById(`status-${id}`);
                status.innerHTML = 'cancelled';
                cancelBtn.innerHTML = 'Cenelling...';
                setTimeout(() => {
                    parentElement.remove();
                }, 100);
               
                toastNotification(message, 'success', 3000);

            } else {
                toastNotification(message, 'error', 3000);             
            }
        }

    }

async function request(id, route) {
        try {
            const response = await fetch(route, {
                method: 'DELETE',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    booking_id: id
                })
            });

            if (!response.ok) {
                return {
                    success: false,
                    message: 'Something went wrong'
                };
            }

            const data = await response.json();

            return {
                success: data.success,
                message: data.message
            };
        } catch (error) {
            console.error(error);
            return {
                success: false,
                message: 'Something went wrong'
            };
        }
    }
</script>

@endsection