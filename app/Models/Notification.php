<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public static $TYPE_BOOKING_REQUEST = 'booking_request';
    public static $TYPE_BOOKING_ACCEPTED = 'booking_accepted';
    public static $TYPE_BOOKING_REJECTED = 'booking_rejected';

    public static $TYPE_NEW_SESSION_CREATED = 'new_session_created';
    public static $TYPE_SESSION_REMINDER = 'session_reminder';
    public static $TYPE_SESSION_CANCELLED = 'session_cancelled';

    public static $TYPE_NEW_MESSAGE = 'new_message';

    public static $TYPE_NEW_RESOURSE = 'new_resource';
    


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   

    protected $fillable = [
        'user_id',
        'room_id',
        'type',
        'message',
        'is_read',
        'url',
    ];

    // Add new notification
    public static function add($user_id, $room_id, $type, $message, $url){
        $notification = Notification::create([
            'user_id' => $user_id,
            'room_id' => $room_id,
            'type' => $type,
            'message' => $message,
            'url' => $url,
        ]);

        return $notification;
    }

    // Mark notification as read
    public static function markAsRead($id){
        $notification = Notification::find($id);
        $notification->is_read = true;
        $notification->save();
    }   
}