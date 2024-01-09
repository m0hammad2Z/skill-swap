<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $fillable = [
         'room_id',
         'user_id',
     ];

    public static function add($room_id, $user_id){
        $roomMember = RoomMember::create([
            'room_id' => $room_id,
            'user_id' => $user_id,
        ]);

        return $roomMember;
    }
}
