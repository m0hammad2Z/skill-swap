<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Skill;
use App\Models\RoomMember;
use App\Models\User;
use App\Models\Booking;
use App\Models\VideoSession;
use App\Models\Notification;
use App\Models\Resource;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Validator;
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

    // search rooms (GET) in real time (json response)
    public function search(Request $request){
        $search = $request->string;
        $rooms = Room::where('name', 'LIKE', "%{$search}%")->lessThanMaxAttendees()->active()->notPrivate()->UserNotAmemeber(auth()->user()->id)->get();

        if ($rooms->isEmpty()) {
            return jsonResponese(false, 'No rooms found', 404);
        }

        foreach($rooms as $room){
            $room->skill_to_learn = Skill::find($room->skill_to_learn_id);
            $room->skill_to_teach = Skill::find($room->skill_to_teach_id);
            $room->user = User::find($room->user_id);
            $room->membersCount = $room->members->count();
        }

        return jsonResponeseWithData(true, 'Rooms fetched successfully', $rooms, 200);
    }


    // Create a new room (GET)
    public function create(){
        $skills = Skill::all();
        $userSkills = auth()->user()->skills;

        return view('website.rooms.create', compact('skills', 'userSkills'));
    }

    // Show a room(Not Joined) (GET)
    public function show($id){       
        $room = Room::with(['user' => function($query){
            return $query->select('id', 'first_name', 'last_name', 'username');
        }])->find($id);

        $room->skill_to_learn = Skill::find($room->skill_to_learn_id);
        $room->skill_to_teach = Skill::find($room->skill_to_teach_id);

        $lastBooking = Booking::where('room_id', $id)->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->first();
        $room->lastBooking = $lastBooking;
        return view('website.rooms.show-room', compact('room'));
    }

    // List User's rooms (GET)
    public function showUserRooms(){

        // Get all the rooms that the user members of
        $rooms = auth()->user()->rooms()->get();
        
        

        return view('website.rooms.myrooms', compact('rooms'));
    }

    // Store a new room (POST)
    public function store(Request $request){
        // Validate the request...
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'skill_to_learn_id' => 'required',
            'skill_to_teach_id' => 'required',
            'max_participants' => 'required|integer|min:2|max:10',
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

        if(!$request->is_featured){
            $request->featured_until = null;
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



    // ------------------------------ In Room ------------------------------
    // Show joined room (GET)
    public function showJoinedRoom($id){
        $room = Room::with(['user' => function($query){
            return $query->select('id', 'first_name', 'last_name', 'username');
        }])->find($id);

        $room->skill_to_learn = Skill::find($room->skill_to_learn_id);
        $room->skill_to_teach = Skill::find($room->skill_to_teach_id);

        $room->isMember = $room->members->contains('id', auth()->user()->id);   
        
        return view('website.rooms.joinedRoom', compact('room'));
    }
    

    // Update a room (PATCH)
    public function updateRoom($roomId){
        $validated = Validator::make(request()->all(), [
            'name' => 'required|max:30',
            'description' => 'required',
            'access_code' => 'nullable',
            'requirements' => 'nullable',
            'learning_outcomes' => 'nullable',
        ]);

        if($validated->fails()){
            return redirect()->back()->with('error', 'Please fill all the fields correctly');
        }

        $room = Room::find($roomId);

        if($room->user_id != auth()->user()->id){
            return redirect()->back()->with('error', 'You are not authorized to update this room');
        }

        $room->name = request('name');
        $room->description = request('description');
        $room->access_code = request('access_code');
        $room->requirements = request('requirements');
        $room->learning_outcomes = request('learning_outcomes');

        $room->save();

        return redirect()->back()->with('success', 'Room updated successfully');
    }

    // Kick a member (DELETE)
    public function kickMember($roomId, $memberId){
        try{
            $room = Room::find($roomId);

            if($memberId == $room->user_id){
                return jsonResponese(false, 'You are the owner of this room, you cannot leave', 403);
            }

            if($room->user_id != auth()->user()->id){
                return jsonResponese(false, 'You are not authorized to kick members from this room', 403);
            }

            $roomMember = RoomMember::where('room_id', $roomId)->where('user_id', $memberId)->first();      

            Booking::where('room_id', $roomId)->where('user_id', $memberId)->delete();

            $notification = Notification::add($memberId, $roomId, Notification::$TYPE_KICKED_OUT, 'You have been kicked out of the room', '/rooms/');
            $notification->save();
            $roomMember->delete();

            return jsonResponese(true, 'Member kicked successfully', 200);
        }
        catch(\Exception $e){
            return jsonResponese(false, $e->getMessage(), 403);
        }
    }
    

    // Leave a room (DELETE)
    public function leaveRoom($roomId){
        try{
            $room = Room::find($roomId);

            if($room->user_id == auth()->user()->id){
                return jsonResponese(false, 'You are the owner of this room, you cannot leave', 403);
            }

            $roomMember = RoomMember::where('room_id', $roomId)->where('user_id', auth()->user()->id)->first();
            $roomMember->delete();
            $room->save();

            Booking::where('room_id', $roomId)->where('user_id', auth()->user()->id)->delete();

            return jsonResponese(true, 'You left the room successfully', 200);
        }
        catch(\Exception $e){
            return jsonResponese(false, 'Something went wrong, please try again later', 403);
        }
    }

    
}
