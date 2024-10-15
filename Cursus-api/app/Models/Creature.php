<?php

namespace App\Models;

use App\Enums\CreatureTypeEnum;
use App\Enums\CreatureRaceEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creature extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'pv',
        'atk',
        'def',
        'speed',
        'type',
        'race',
        'capture_rate'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => CreatureTypeEnum::class,
            'race' => CreatureRaceEnum::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class);
    }

    static public function search(string $name = null, string $minPv = null, string $maxPv = null, int $page = null, int $limit = null)
    {
        $query = self::query();

        if ($name) {
            $query->where('name', $name);
        }

        if (is_numeric($minPv)) {
            $query->where('pv', '>', $minPv);
        }

        if (is_numeric($maxPv)) {
            $query->where('pv', '<', $maxPv);
        }

        $totalResults = $query->count();
        $query->orderBy('id', 'ASC');

        if ($page && $limit) {
            $query->skip(($page - 1) * $limit)->take($limit);
        }

        return ['creatures' => $query->get(), 'totalResults' => $totalResults];
    }
}