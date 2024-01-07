<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    // List all rooms (GET)
    public function index() {
        // Get all the rooms that have members less than the max_attendees and are active and not private 
        $rooms = Room::lessThanMaxAttendees()->active()->notPrivate()->get();
        
        return view('website.rooms.index', compact('rooms'));
    }

    // Create a new room (GET)
    public function create(){
        return view('website.rooms.create');
    }

    // Show a room(Not Joined) (GET)
    public function show($id){
        return view('website.rooms.show-room');
    }

    // List User's rooms (GET)
    public function showUserRooms(){
        return view('website.rooms.myrooms');
    }

    // Show joined room (GET)
    public function showJoinedRoom($id){
        return view('website.rooms.joinedRoom');
    }

    // Store a new room (POST)
    public function store(Request $request){
        // Validate the request...
        $request->validate([
            'name' => 'required|unique:rooms|max:255',
            'description' => 'required',
        ]);

        $room = new Room;

        $room->name = $request->name;
        $room->description = $request->description;
        $room->user_id = $request->user()->id;
        $room->skill_to_learn_id = $request->skill_to_learn_id;
        $room->skill_to_teach_id = $request->skill_to_teach_id;
        $room->max_attendees = $request->max_attendees;
        $room->access_code = $request->access_code;
        $room->requirements = $request->requirements;
        $room->learning_outcomes = $request->learning_outcomes;
        $room->is_resources_provided = $request->is_resources_provided;
        $room->is_featured = $request->is_featured;
        $room->is_private = $request->is_private;
        $room->is_active = $request->is_active;
        $room->featured_expires_at = $request->featured_expires_at;

        $room->save();

        return redirect('/rooms');
    }
    

    
}
