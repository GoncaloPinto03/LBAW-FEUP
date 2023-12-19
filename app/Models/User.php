<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    public $primaryKey = 'user_id';

    /**x§
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function photo() {
        $files = glob("images/profile/".$this->user_id.".jpg", GLOB_BRACE);
        $default = "/images/profile/default_pic.jpg";
        if(sizeof($files) < 1) return $default;
        return "/".$files[0];
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function article_vote()
    {
        return $this->hasMany(Article_vote::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function follow($userId)
    {
        $this->following()->attach($userId);
    }

    public function unfollow($userId)
    {
        $this->following()->detach($userId);
    }

    public function isFollowing($userId)
    {
        return $this->following()->where('follower_id', $userId)->exists();
    }
}
