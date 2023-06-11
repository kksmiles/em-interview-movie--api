<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, SoftDeletes;
    // use HasApiTokens, HasFactory, Notifiable, SoftDeletes, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'theme_settings',
        // 'password',
    ];

    /*
    protected $hidden = [
        'password',
        'remember_token',
    ];
    */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        // 'password' => 'hashed',
        'theme_settings' => 'json',
    ];

    public function favourite_movies()
    {
        return $this->belongsToMany(Movie::class, 'user_favourite_movies', 'user_id', 'movie_id');
    }

    public function favourite_categories()
    {
        return $this->belongsToMany(Category::class, 'user_favourite_categories', 'user_id', 'category_id');
    }

    public function favourite_tags()
    {
        return $this->belongsToMany(Tag::class, 'user_favourite_tags', 'user_id', 'tag_id');
    }
}
