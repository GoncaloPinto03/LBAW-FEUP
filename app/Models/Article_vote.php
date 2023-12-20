<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_vote extends Model
{
    use HasFactory;

    protected $table = 'article_vote';

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }

    public function article()
    {
        $this->belongsTo(Article::class, 'article_id');
    }
}


