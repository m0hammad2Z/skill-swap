@extends('website.layouts.app')

@section('title', 'Reuqests')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
@endsection

@section('content')

<div class="container">
    <div id="resourceList">
        <h1 class="section-title">My Requests</h1>
        @php
            $prendingCount = $requests->filter(function($request){
                return $request->status == 'pending';
            })->count();

        @endphp

        <h1 class="subtitle">You have {{ $prendingCount }} requests</h1>

        @if ($requests->count() == 0)
            <div class="empty" style="text-align: center; margin: 8em auto;">
                <i class="fas fa-envelope" style="font-size: 9em;"></i>
                <h1>No requests yet</h1>
                <p>Once you send a request, it will appear here</p>
            </div>
        @else
       
            <div class="table-titles vcard">
                <strong>User</strong>
                <strong>Room</strong>
                <strong>Date</strong>
                <strong>Status</strong>
                <strong>Action</strong>
            </div>
            @foreach($requests as $request)
            <div class="vcard">
                <div class="vcard-title">
                    <h4>{{ $request->username }}</h4>
                </div>
                <div class="date vcard__content">
                    <p>{{ $request->name }}</p>
                </div>
                <div class="date vcard__content">
                    <p>{{ $request->booked_at }}</p>
                </div>
                <div class="status vcard__content" id="status-{{ $request->id }}">
                    <p>{{ $request->status }}</p>
                </div>

                <div class="action">
                    @if ($request->status == 'pending')
                        <button class="cta-button" id="accept-btn-{{ $request->id }}" onclick='acceptRequest({{ $request->id }})'>Accept</button>
                        <button class="red-button" id="reject-btn-{{ $request->id }}" onclick='rejectRequest({{ $request->id }})'>Reject</button>
                    @elseif ($request->status == 'approved')
                        <button class="cta-button" onclick="window.location.href='/myrooms/{{ $request->room_id }}'">View Room</button>
                    @endif
                </div>
            </div>

        @endforeach

        @endif
        
        
    </div>
</div>

<script>
    // Accept request function ( accept the request and change the status to accepted)
    async function acceptRequest(id) {   
        let status = document.getElementById('status-' + id);
        let acceptBtn = document.getElementById('accept-btn-' + id);
        let rejectBtn = document.getElementById('reject-btn-' + id);

        const sweetAlert = await confirmModal('Are you sure?', 'You are about to accept this request', 'warning', 'Yes, accept it', 'No, cancel')

        if (sweetAlert.isConfirmed) {
            const result = await request(id, '{{ route('bookings.accept') }}');
            const { success, message } = result;

            if (success) {
                status.innerHTML = 'approved';
                acceptBtn.innerHTML = 'View Room';
                rejectBtn.style.display = 'none';
                toastNotification(message, 'success', 3000);
            } else {
                toastNotification(message, 'error', 3000);
            }
        }
    }

    // Reject request function ( reject the request and change the status to rejected)
    async function rejectRequest(id) {   

        const sweetAlert = await confirmModal('Are you sure?', 'You are about to reject this request', 'warning', 'Yes, reject it', 'No, cancel')

        if (sweetAlert.isConfirmed) {
            const result = await request(id, '{{ route('bookings.reject') }}');
            const { success, message } = result;

            if (success) {
                document.getElementById('status-' + id).innerHTML = 'rejected';
                document.getElementById('accept-btn-' + id).style.display = 'none';
                document.getElementById('reject-btn-' + id).style.display = 'none';
                toastNotification(message, 'success', 3000);
            } else {
                toastNotification(message, 'error', 3000);
            }
        }        
    }

    async function request(id, route) {
        try {
            const response = await fetch(route, {
                method: 'POST',
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
            return {
                success: false,
                message: 'Something went wrong'
            };
        }
    }


</script>


@endsection