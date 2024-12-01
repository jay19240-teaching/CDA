<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'power',
        'strong',
        'type'
    ];

    public function creatures()
    {
        return $this->belongsToMany(Creature::class);
    }
}