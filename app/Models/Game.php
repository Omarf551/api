<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_categori',
        'games', 
        'photo',
        'synopses',
        'review',
        'likes',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_categori', 'id');
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
