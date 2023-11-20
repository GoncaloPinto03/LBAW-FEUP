<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Article extends Model
{
    protected $table = 'article';
    protected $primaryKey = 'article_id';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id')->get();
    }

    /*public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }*/

}