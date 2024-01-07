<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'skill_to_learn_id',
        'skill_to_teach_id',
        'max_attendees',
        'name',
        'description',
        'image',
        'access_code',
        'requirements',
        'learning_outcomes',
        'is_resources_provided',
        'is_featured',
        'is_private',
        'is_active',
        'featured_expires_at',
    ];

    // ------------ Scope ------------
    public function scoprLessThanMaxAttendees($query)
    {
        return $query->where('max_attendees', '<', $this->members->count());
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNotPrivate($query)
    {
        return $query->where('is_private', false);
    }

    // ---------- Users ----------

    //  Get the user that owns the room.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get the members of the room.
    public function members()
    {
        return $this->belongsToMany(User::class, 'room_members');
    }

    // ---------- Video Sessions ----------

    //  Get the video sessions of the room.
    public function video_sessions()
    {
        return $this->hasMany(VideoSession::class);
    }

    // ---------- Booking ----------
    
    //  Get the bookings of the room.
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // ---------- Ratings ----------

    //  Get the ratings of the room.
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // ------------ Resource ------------
    //  Get the resources of the room.
    public function resources()
    {
        return $this->hasMany(Resource::class);
    }
}
