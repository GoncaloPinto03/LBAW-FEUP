<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'article_tag';
    
    protected $fillable = [
        'article_id', 'tag_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
