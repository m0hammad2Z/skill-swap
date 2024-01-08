<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    // Store a new booking (POST)
    public function store(Request $request){
        // Validate the request
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => 'required|exists:users,id',
            'booked_at' => 'required|date|after_or_equal:today',
        ]);

        // Create a new booking
        $booking = auth()->user()->bookings()->create([
            'room_id' => $request->room_id,
            'booked_at' => $request->booked_at,
        ]);

        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Booking created successfully');
    }

    
}
