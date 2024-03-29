<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    //1対多でユーザーに紐づいたTweetデータを取得する
    public function userTweets(){
        return $this->hasMany(Tweet::class);
    }


    //多対多の連携 いいね機能
    public function tweets(){
        return $this->belongsToMany(Tweet::class)->withTimestamps();
    }


    //多対多の連携 フォローしている
    public function followings(){
        return $this->belongsToMany(self::class, "follows", "user_id", "following_id")->withTimestamps();
    }
    //多対多の連携 フォロワーされている
    public function followers(){
        return $this->belongsToMany(self::class, "follows", "following_id", "user_id")->withTimestamps();
    }

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
}
