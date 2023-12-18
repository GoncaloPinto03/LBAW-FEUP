<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleNotif extends Model
{
    use HasFactory;
    protected $table = 'article_notification';
    public $timestamps = false;

    protected $fillable = [
        'notification_id', 'article_id'
    ];
}
