<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'tag_id';
    protected $fillable = ['name'];
    protected $table = 'tag';

    public function getTags($id)
    {
        return ArticleTag::where('article_id', $id);
    }

}
