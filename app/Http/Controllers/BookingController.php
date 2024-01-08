<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Notification;

class BookingController extends Controller
{
    // Store a new booking (POST) / Ask to join a room
    public function store(Request $request){
        $request->validate([
            'room_id' => 'required',
            'user_id' => 'required',
        ]);

        
        // Check if the user already asked to join this room and answer with json
        if (Booking::where('user_id', auth()->user()->id)->where('room_id', $request->room_id)->exists()) {
            return jsonResponese(false, 'You already asked to join this room', 400);
        }
        
        try{
            // Create a new booking
            $booking =  Booking::add(auth()->user()->id, $request->room_id, Carbon::now());
            
            // Create a new notification
            $notification = Notification::add(auth()->user()->id, $request->room_id, Notification::$TYPE_BOOKING_REQUEST, 'You have a new booking request', 'bookings/' . $booking->id);
            
            
            $booking->save();
            $notification->save();

            return jsonResponese(true, 'Your request has been sent successfully', 200);
        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }    

    // Accept a booking (POST)
    public function accept(Request $request){
        $request->validate([
            'booking_id' => 'required',
        ]);

        try{
            Booking::markAsAccepted($request->booking_id);

            $notification = Notification::add(auth()->user()->id, Booking::find($request->booking_id)->room_id, Notification::$TYPE_BOOKING_ACCEPTED, 'Your booking request has been accepted', 'bookings/' . $request->booking_id);
            $notification->save();

            return jsonResponese(true, 'Booking has been accepted successfully', 200);
        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }

    // Reject a booking (POST)
    public function reject(Request $request){
        $request->validate([
            'booking_id' => 'required',
        ]);

        try{
            Booking::markAsRejected($request->booking_id);

            $notification = Notification::add(auth()->user()->id, Booking::find($request->booking_id)->room_id, Notification::$TYPE_BOOKING_REJECTED, 'Your booking request has been rejected', 'bookings/' . $request->booking_id);
            $notification->save();

            return jsonResponese(true, 'Booking has been rejected successfully', 200);
        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }

    // Cancel a booking (POST)
    public function cancel(Request $request){
        $request->validate([
            'booking_id' => 'required',
        ]);

        try{
            Booking::markAsCancelled($request->booking_id);

            return jsonResponese(true, 'Booking has been cancelled successfully', 200);
        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }



}





// ----------------- Helper Functions ----------------- //

// Helper function to return json response
function jsonResponese($success, $message, $code){
    return response()->json(['success' => $success, 'message' => $message], $code);
}



