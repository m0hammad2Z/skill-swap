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

    // Mark all notifications as read
    public static function markAllAsRead($user_id){
        $notifications = Notification::where('user_id', $user_id)->get();
        foreach($notifications as $notification){
            $notification->is_read = true;
            $notification->save();
        }
    }    
}