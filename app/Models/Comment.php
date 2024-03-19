<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_game',
        'id_user',
        'comment',
        'datetime',  

    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user', 'id');
}
public function game()
    {
        return $this->belongsTo(Game::class);
    }

}
