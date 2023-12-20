<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;



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
    function generateSlug($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

    public function photo()
    {
        $files = glob("images/article/" . $this->article_id . ".jpg", GLOB_BRACE);
        if (sizeof($files) < 1) return null;
        return "/" . $files[0];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tag', 'article_id', 'tag_id');
    }
  

}