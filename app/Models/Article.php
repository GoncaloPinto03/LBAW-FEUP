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

    public function article_vote()
    {
        return $this->hasMany(Article_vote::class, 'article_id');
    }


    /*public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }*/
    public function photo()
    {
        $files = glob("images/article/" . $this->article_id . ".jpg", GLOB_BRACE);
        $default = "/images/article/default_article_pic.jpg";
        if (sizeof($files) < 1) return $default;
        return "/" . $files[0];
    }


}