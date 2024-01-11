<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public static $STATUS_PENDING = 'pending';
    public static $STATUS_ACCEPTED = 'approved';
    public static $STATUS_REJECTED = 'rejected';
    
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

    public static function markBooking($booking_id, $status){
        $booking = Booking::find($booking_id);
        $booking->status = $status;
        $booking->save();
    }

    
}
