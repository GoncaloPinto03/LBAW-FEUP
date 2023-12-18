<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DislikePostNotif extends Model
{
    use HasFactory;
    protected $table = 'dislike_post';
    public $timestamps = false;

    protected $fillable = [
        'notification_id', 'user_id'
    ];
}
