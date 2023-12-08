<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicProposal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'date', 'accepted'];
    protected $primaryKey = 'topicproposal_id';
    protected $table = 'topicproposal';

    public $timestamps = false;
}
