<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;
    protected  $fillable = 
    [
        'name',
        'user_id',
    ];


    public function pictuers()
    {
        return $this->hasMany(Pictuer::class ,'album_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class ,'user_id', 'id');
    }
}
