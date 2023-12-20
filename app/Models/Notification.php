<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';
    public $timestamps = false;
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'date', 'viewed', 'notified_user', 'emitter_user'
    ];
}
