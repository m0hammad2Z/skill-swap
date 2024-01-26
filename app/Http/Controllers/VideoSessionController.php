<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\VideoSession;
use App\Models\Notification;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class VideoSessionController extends Controller
{

    private $wherebyApiKey ="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmFwcGVhci5pbiIsImF1ZCI6Imh0dHBzOi8vYXBpLmFwcGVhci5pbi92MSIsImV4cCI6OTAwNzE5OTI1NDc0MDk5MSwiaWF0IjoxNzA0OTczNjcwLCJvcmdhbml6YXRpb25JZCI6MjA0NTE1LCJqdGkiOiIyNTYzMjkzMy05YmY4LTQ3NWItOGM5Yy0wODQ0MzEwYzFmOWQifQ.SVb4TLpOG3W_pSpeYe8WajQEjyAI1QAKI14bQCvupDo";

    // Store the video session
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'room_id' => 'required',
        ]);
    

        $lastSession = VideoSession::getLastSession($request->room_id);

        // if the room time is not finished yet
        if ($lastSession && Carbon::parse($lastSession->started_at)->addDays(6)->isFuture()) {
            return redirect()->back()->withErrors(['error' => 'You cannot create a new session now, please try again later']);
        }

        $videoSessionResponse = $this->create($request);

        // Adjust the key access based on the actual API response structure
        $apiSessionsKey = $videoSessionResponse['roomUrl'];
        $started_at = now();

        // Notificition to the users
        $room = Room::find($request->room_id);
        $roomMembers = $room->members;

        // TODO
        foreach ($roomMembers as $member) {
            if ($member->id == auth()->user()->id) {
                continue;
            }

            $message = 'New session created for room ' . $room->name;
            $url = '/myrooms/' . $room->id;
            Notification::add($member->id, $room->id, Notification::$TYPE_NEW_SESSION_CREATED, 'New session created', '/rooms/' . $url);
        }

        VideoSession::add($request->name, $request->room_id, $apiSessionsKey, $started_at)->save();

        return redirect('/myrooms/' . $request->room_id)->with('success', 'Video session created successfully');
    }

    // Create a new video session in the whereby API
    public function create(Request $request)
    {
        $bearerToken = "Bearer " . $this->wherebyApiKey;

        $endDate = now()->addDays(6)->format('Y-m-d\TH:i:s\Z');


        $response = Http::withOptions([
            'verify' => false,
        ])->withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $bearerToken,
        ])->post('https://api.whereby.dev/v1/meetings', [
            'endDate' => $endDate,
            'roomMode' => 'group',
        ]);

        return $response->json();
    }
}
