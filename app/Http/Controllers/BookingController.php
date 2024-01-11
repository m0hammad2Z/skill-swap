<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Notification;
use App\Models\User;
use App\Models\Room;
use App\Models\RoomMember;




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
            
            // Get the room owner id
            $roomOwnerId = Room::find($request->room_id)->user->id;
            
            // Create a new notification
            $message = auth()->user()->username . ' wants to join ' . Room::find($request->room_id)->name;
            $url = '/myrequests';
            $notification = Notification::add($roomOwnerId, $request->room_id, Notification::$TYPE_BOOKING_REQUEST, $message, $url);
            
            
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

        $booking = Booking::find($request->booking_id);
        
        if($booking->status == Booking::$STATUS_ACCEPTED){
            return jsonResponese(false, 'Booking has already been accepted', 400);
        }
        
        try{ 
            $user_id = $booking->user_id;
            $room_id = $booking->room_id;
            
            $roomMember = RoomMember::add($room_id, $user_id);
            
            $message = 'Your request to join ' . Room::find($room_id)->name . ' has been accepted';
            $url = 'rooms/' . $room_id;

            $notification = Notification::add($user_id, $room_id, Notification::$TYPE_BOOKING_ACCEPTED, $message, $url);
            
            $roomMember->save();
            $notification->save();
            
            Booking::markBooking($request->booking_id, Booking::$STATUS_ACCEPTED);
            
            return jsonResponese(true, 'Booking has been accepted successfully', 200);
        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later' . $e, 403);
        }
    }

    // Reject a booking (POST)
    public function reject(Request $request){
        $request->validate([
            'booking_id' => 'required',
        ]);

        $booking = Booking::find($request->booking_id);

        if($booking->status == Booking::$STATUS_REJECTED){
            return jsonResponese(false, 'Booking has already been rejected', 400);
        }

        try{
            $user_id = $booking->user_id;
            $room_id = $booking->room_id;
            
            $message = 'Your request to join ' . Room::find($room_id)->name . ' has been rejected';
            $url = '/myrequests';
            
            $notification = Notification::add($user_id, Booking::find($request->booking_id)->room_id, Notification::$TYPE_BOOKING_REJECTED, $message, $url);
            $notification->save();
            
            Booking::markBooking($request->booking_id, Booking::$STATUS_REJECTED);

            return jsonResponese(true, 'Booking has been rejected successfully', 200);
        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }

    // Delete a booking (delete)
    public function cancel(Request $request){
        $request->validate([
            'booking_id' => 'required',
        ]);    

        try{
            Booking::find($request->booking_id)->delete();
            return jsonResponese(true, 'Booking has been deleted successfully', 200);

        }catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }


    // My Requests (GET)
    public function myRequests(){

        // Get all the ids, name of the roomes user owns
        $rooms = auth()->user()->roomsOwned()->get(['id', 'name']);

        // Get all the requests to join any of the user's rooms
        $requests = Booking::whereIn('room_id', $rooms->pluck('id'))
        ->join('users', 'bookings.user_id', '=', 'users.id')
        ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
        ->get(
            [
                'bookings.id',
                'bookings.user_id',
                'bookings.room_id',
                'bookings.booked_at',
                'bookings.status',
                'users.username',
                'rooms.name',
            ]
        );


        return view('website.myrequests', compact('requests'));
    }

    // My Offers (GET)
    public function myOffers(){
        $offers = Booking::where('bookings.user_id', auth()->user()->id)
        ->join('rooms', 'bookings.room_id', '=', 'rooms.id')->get(
            [
                'bookings.id',
                'bookings.room_id',
                'bookings.booked_at',
                'bookings.status',
                'rooms.name',
            ]
        );

        return view('website.myoffers', compact('offers'));
    }

}