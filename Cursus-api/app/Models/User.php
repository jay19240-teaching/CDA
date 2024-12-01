<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Models\Creature;
use App\Enums\RoleEnum;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
    ];

    protected $attributes = [
        'role' => RoleEnum::ROLE_USER
    ];

    protected $hidden = [
        'password',
        'token',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
        ];
    }

    public function creatures()
    {
        return $this->hasMany(Creature::class);
    }

    public function isAdmin()
    {
        return $this->role === RoleEnum::ROLE_ADMIN;
    }

    public function resolveRouteBinding($value, $field = null): ?self
    {
        return $value === 'me' ? Auth::user() : parent::resolveRouteBinding($value, $field);
    }
}