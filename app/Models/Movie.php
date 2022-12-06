<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}