<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;


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
        $this->incrementFollowerCount();

    }

    public function unfollow($userId)
    {
        $this->following()->detach($userId);
        $this->decrementFollowerCount();
    }

    public function isFollowing($userId)
    {
        return $this->following()->where('follower_id', $userId)->exists();
    }

    public function incrementFollowerCount()
    {
        $this->number_followers = $this->number_followers + 1;
        $this->save();
    }

    public function decrementFollowerCount()
    {
        $this->number_followers = $this->number_followers - 1;
        $this->save();
    }

    public function followingTags()
    {
        return $this->belongsToMany(User::class,'follow', 'user_id', 'tag_id');
    }

    public function isFollowingTag($tagId)
    {
        return $this->followingTags()->where('tag_id', $tagId)->exists();
    }

    public function followTag($tagId)
    {
        $this->followingTags()->attach($tagId);
    }

    public function unfollowTag($tagId)
    {
        $this->followingTags()->detach($tagId);
    }

    public function getMyFeed()
    {
        $user = Auth::user();

        $followingUserIds = $user->following()->pluck('follower_id')->toArray();
        $followingTags = $user->followingTags()->pluck('tag_id')->toArray();

        $followedItems = array_merge($followingTags, $followingUserIds);

        $query = Article::query();

        $articles = $query->whereHas('tags', function ($query) use ($followingTags) {
            $query->whereIn('article_tag.tag_id', $followingTags);
        })->orWhereIn('user_id', $followingUserIds)->orderBy('date', 'desc')->get();
        return $articles;
    }


}
