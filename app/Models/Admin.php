<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model implements Authenticatable
{
    use AuthenticatableTrait, HasApiTokens, Notifiable;

    protected $table = 'admin'; // specify the table name if it's different from the class name

    protected $primaryKey = 'admin_id'; // specify the primary key if it's different from the default 'id'

    protected $fillable = [
        'name', 'email', 'password',
    ];

    // You may also want to customize other aspects of the model, such as timestamps
    public $timestamps = false;

    
}
