<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public static $STATUS_PENDING = 'pending';
    public static $STATUS_ACCEPTED = 'accepted';
    public static $STATUS_REJECTED = 'rejected';
    public static $STATUS_CANCELLED = 'cancelled';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'room_id',
        'booked_at',
        'staus',
    ];

    

    public static function add($user_id, $room_id, $booked_at){
        $booking = Booking::create([
            'user_id' => $user_id,
            'room_id' => $room_id,
            'booked_at' => $booked_at,
            'status' => Booking::$STATUS_PENDING,
        ]);

        return $booking;
    }

    public static function markAsAccepted($id){
        $booking = Booking::find($id);
        $booking->status = Booking::$STATUS_ACCEPTED;
        $booking->save();
    }

    public static function markAsRejected($id){
        $booking = Booking::find($id);
        $booking->status = Booking::$STATUS_REJECTED;
        $booking->save();
    }

    public static function markAsCancelled($id){
        $booking = Booking::find($id);
        $booking->status = Booking::$STATUS_REJECTED;
        $booking->save();
    }
    
}
