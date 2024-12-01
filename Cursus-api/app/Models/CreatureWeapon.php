<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CreatureWeapon extends Pivot
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'weapon_id',
        'creature_id'
    ];

    public function creatures()
    {
        return $this->hasMany(Creature::class);
    }

    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
}