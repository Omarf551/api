<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_game',
        'Genere',  

    ];


    public function games()
{
    return $this->hasMany(Game::class, 'id_categori', 'id');
}
}
