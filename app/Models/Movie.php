<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'length_in_seconds',
        'released_at',
        'available_until',
    ];

    protected $hidden = [
        'id',
        'pivot',
    ];

    protected $casts = [
        'released_at' => 'datetime',
        'available_until' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function (Movie $movie) {
            $slug = Str::slug($movie->title) . '-' . Str::random(6) . '-' . time();
            $movie->slug = $slug;
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function pictures(): HasMany
    {
        return $this->hasMany(MoviePicture::class)->orderBy('order');
    }
}
