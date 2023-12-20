<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikePostNotif extends Model
{
    use HasFactory;
    protected $table = 'like_post';
    public $timestamps = false;

    protected $fillable = [
        'notification_id', 'user_id'
    ];
}
