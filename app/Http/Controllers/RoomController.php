<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Skill;
use App\Models\RoomMember;
use Carbon\Carbon;

class RoomController extends Controller
{
    // List all rooms (GET)
    public function index() {
        // Get all the rooms that have members less than the max_attendees and are active and not private 
        $rooms = Room::lessThanMaxAttendees()->active()->notPrivate()->UserNotAmemeber(auth()->user()->id)->get();

        foreach($rooms as $room){
            $room->skill_to_learn = Skill::find($room->skill_to_learn_id);
            $room->skill_to_teach = Skill::find($room->skill_to_teach_id);
            $room->membersCount = $room->members->count();
        }

        return view('website.rooms.index', compact('rooms'));
    }

    // Create a new room (GET)
    public function create(){
        $skills = Skill::all();
        $userSkills = auth()->user()->skills;

        return view('website.rooms.create', compact('skills', 'userSkills'));
    }

    // Show a room(Not Joined) (GET)
    public function show($id){
        return view('website.rooms.show-room');
    }

    // List User's rooms (GET)
    public function showUserRooms(){

        // Get all the rooms that the user members of
        $rooms = auth()->user()->rooms()->get();
        
        

        return view('website.rooms.myrooms', compact('rooms'));
    }

    // Show joined room (GET)
    public function showJoinedRoom($id){
        return view('website.rooms.joinedRoom');
    }

    // Store a new room (POST)
    public function store(Request $request){
        // Validate the request...
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'skill_to_learn_id' => 'required',
            'skill_to_teach_id' => 'required',
            'max_participants' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
            'access_code' => 'nullable',
            'requirements' => 'nullable',
            'learning_outcomes' => 'nullable',
            'is_resource_enabled' => 'nullable',
            'is_featured' => 'nullable',
            'is_private' => 'nullable',
            'is_active' => 'nullable',
            'featured_until' => 'nullable|integer',
        ]);

        // Validate the cost
        $cost = $this->validateCost($request);
        if($cost > auth()->user()->sbucks_balance){
            return redirect()->back()->with('error', 'You do not have enough Sbucks to create this room');
        }

        // Add the featured_until date
        if($request->is_featured){
            $request->featured_until = Carbon::now()->addHours($request->featured_until);
            $request->is_private = false;
        }



        if($request->hasFile('image')){
            $path = $request->file('image')->store('rooms', 'public');
            $request->image = $path;
        }


        $room = new Room;

        $room->user_id = $request->user()->id;
        $room->skill_to_learn_id = $request->skill_to_learn_id;
        $room->skill_to_teach_id = $request->skill_to_teach_id;
        $room->max_attendees = $request->max_participants;
        $room->name = $request->name;
        $room->description = $request->description;
        $room->access_code = $request->access_code;
        $room->requirements = $request->requirements;
        $room->learning_outcomes = $request->learning_outcomes;
        $room->is_resources_provided = $request->is_resource_enabled ?? false;
        $room->is_featured = $request->is_featured ?? false;
        $room->is_private = $request->is_private ?? false;
        $room->is_active = $request->is_active ?? true;
        $room->featured_expires_at = $request->featured_until;
        $room->image = $request->image;

        $room->save();

        // Add the room owner as a member
        $roomMember = new RoomMember;
        $roomMember->user_id = $request->user()->id;
        $roomMember->room_id = $room->id;
        $roomMember->save();

        // Add the room members
        auth()->user()->sbucks_balance -= $cost;
        auth()->user()->save();

        return redirect('/myrooms');
    }

    function validateCost(Request $request){
        $isPrivate = $request->is_private;
        $isFeatured = $request->is_featured;
        $isResourcesProvided = $request->is_resource_enabled;
        $until = $request->featured_until;
        $maxAttendees = $request->max_participants;

        $cost = 0;

        if($isPrivate){
            $cost += 10;
        }

        if($isFeatured){
            $cost += $until * 2;
        }

        if($isResourcesProvided){
            $cost += 10;
        }
        
        if($maxAttendees > 4){
            $cost += ($maxAttendees - 4) * 5;
        }

        return $cost;
    }
    

    
}
