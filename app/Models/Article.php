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

    public static function getPopularArticles() {
        $articles = Article::orderBy('likes', 'desc')->take(5)->get();
        return $articles;
    }

    public function photo()
    {
        $files = glob("images/news/" . $this->article_id . ".jpg", GLOB_BRACE);
        $default = "/images/news/default_article_pic.jpg";
        if (sizeof($files) < 1) return $default;
        return "/" . $files[0];
    }
}