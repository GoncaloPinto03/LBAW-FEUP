<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_vote extends Model
{
    use HasFactory;

    protected $table = 'comment_vote';

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function article()
    {
        $this->belongsTo(Comment::class, 'comment_id');
    }
}
