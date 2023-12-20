<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    protected $table = 'comment';
    protected $primaryKey = 'comment_id';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function comment_vote()
    {
        return $this->hasMany(Comment_vote::class, 'comment_id');
    }
}