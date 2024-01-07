<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
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
            'resource_type',
            'resource_url',
            'description',
        ];
}
