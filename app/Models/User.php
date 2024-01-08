<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Skill;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone_number',
        'country',
        'bio',
        'profile_picture',
        'role',
        'sbucks_balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ---------- Skills ----------

    //  User can have many skills
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skills');
    }

    // -------- Rooms --------

    //  User can be a member of many rooms
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_members');
    }

    //  User can the owner of many rooms
    public function roomsOwned()
    {
        return $this->hasMany(Room::class);
    }

    // ----------- Notifications ------------

    // User can have many notifications
        public function notifications()
        {
            return $this->hasMany(Notification::class);
        }
    
    // ----------- Wallet Transactions ------------

    // User can have many wallet transactions
        public function walletTransactions()
        {
            return $this->hasMany(WalletTransaction::class);
        }

    // ------------ Booking ------------

    // User can make many bookings
        public function bookings()
        {
            return $this->hasMany(Booking::class);
        }


}
