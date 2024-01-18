<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\VideoSession;
use App\Models\Notification;
use App\Models\Resource;
use Illuminate\Support\Facades\Validator;

class ResourceController extends Controller
{
    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'room_id' => 'required',
            'user_id' => 'required',
            'resourceType' => 'required|in:video,image,file|max:255',
            'resourceLink' => 'required|url|max:255',
            'resourceName' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return jsonResponese(false, $validator->errors()->first(), Response::HTTP_BAD_REQUEST);
        }
        

        try{
            $resource = Resource::create([
                'room_id' => $request->room_id,
                'user_id' => $request->user_id,
                'resource_type' => $request->resourceType,
                'resource_url' => $request->resourceLink,
                'description' => $request->resourceName,
            ]);

            // Notify all the room members
            $room = Room::find($request->room_id);
            $roomMembers = $room->members()->get();
            foreach($roomMembers as $member){
                if($member->id == auth()->user()->id){
                    continue;
                }
                $message = auth()->user()->username . ' added a new resource to ' . $room->name;
                $url = '/myrooms/' . $room->id;
                $notification = Notification::add($member->id, $room->id, Notification::$TYPE_NEW_RESOURSE, $message, $url);
                $notification->save();
            }


            return jsonResponese(true, 'Resource added successfully', 200);
        
        }catch(\Exception $e){
            return jsonResponese(false, 'Resource could not be added', 403);
        }
    }

    public function update(Request $request){
        
        $validator = Validator::make($request->all(), [
            'resource_id' => 'required|exists:resources,id',
            'resourceType' => 'required|in:video,image,file|max:255',
            'resourceLink' => 'required|url|max:255',
            'resourceName' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return jsonResponese(false, 'Please fill all the fields correctly', 400);
        }
        

        try{
            $resource = Resource::find($request->resource_id);
            $resource->resource_type = $request->resourceType;
            $resource->resource_url = $request->resourceLink;
            $resource->description = $request->resourceName;
            $resource->save();

            // Notify all the room members
            $room = Room::find($resource->room_id);
            $roomMembers = $room->members()->get();
            foreach($roomMembers as $member){
                if($member->id == auth()->user()->id){
                    continue;
                }
                $message = auth()->user()->username . ' updated a resource in ' . $room->name;
                $url = '/myrooms/' . $room->id;
                $notification = Notification::add($member->id, $room->id, Notification::$TYPE_NEW_RESOURSE, $message, $url);
                $notification->save();
            }
            

            return jsonResponese(true, 'Resource updated successfully', 200);
        
        }catch(\Exception $e){
            return jsonResponese(false, 'Resource could not be updated', 403);
        }
    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'resource_id' => 'required|exists:resources,id',
        ]);

        if ($validator->fails()) {
            return jsonResponese(false, 'Please fill all the fields correctly', 400);
        }

        try{
            $resource = Resource::find($request->resource_id);
            $resource->delete();

            return jsonResponese(true, 'Resource deleted successfully', 200);
        
        }catch(\Exception $e){
            return jsonResponese(false, 'Resource could not be deleted', 403);
        }
    }
}
