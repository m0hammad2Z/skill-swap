<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
        'name',
        'room_id',
        'api_session_id',
        'started_at',
     ];

     public static function add($name, $room_id, $api_session_id, $started_at){

        return VideoSession::create([
            'name' => $name,
            'room_id' => $room_id,
            'api_session_id' => $api_session_id,
            'started_at' => $started_at,
        ]);
     }

     public static function getLastSession($room_id){
        return VideoSession::where('room_id', $room_id)->orderBy('created_at', 'desc')->first();
     }
}
