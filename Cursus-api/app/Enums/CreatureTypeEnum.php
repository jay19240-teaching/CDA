<?php
namespace App\Enums;

use App\Traits\EnumTrait;

enum CreatureTypeEnum: string
{
    use EnumTrait;

    case ELECTRIK = 'ELECTRIK';
    case WATER = 'WATER';
    case FIRE = 'FIRE';
}