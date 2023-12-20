<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentNotif extends Model
{
    use HasFactory;
    protected $table = 'comment_notification';
    public $timestamps = false;

    protected $fillable = [
        'notification_id', 'comment_id'
    ];
}
