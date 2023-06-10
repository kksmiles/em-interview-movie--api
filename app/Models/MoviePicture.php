<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use URL;

class MoviePicture extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'movie_id',
        'title',
        'description',
        'order',
        'path',
    ];

    protected $hidden = [
        'movie_id',
        'deleted_at',
    ];

    protected $appends = [
        'image_url',
    ];

    const ROUTE_PREFIX_PATH = '/api/movie_pictures/fetch?path=';

    protected function imageUrl(): Attribute
    {
        return new Attribute(
            function ($value, $attributes) {
                $path = $attributes['path'];
                if (Str::contains($path, 'https://')) {
                    return $path;
                } else {
                    return URL::to(self::ROUTE_PREFIX_PATH.$path);
                }
            }
        );
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
