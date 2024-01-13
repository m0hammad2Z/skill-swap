<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    public static $VIDEO_RESOURCE = 'video';
    public static $IMAGE_RESOURCE = 'image';
    public static $FILE_RESOURCE = 'file';

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
