<?php
namespace App\Enums;

use App\Traits\EnumTrait;

enum CreatureRaceEnum: string
{
    use EnumTrait;

    case MOUSE = 'MOUSE';
    case DRAGON = 'DRAGON';
    case PLANT = 'PLANT';
}