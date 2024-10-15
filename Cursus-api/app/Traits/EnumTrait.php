<?php

namespace App\Traits;

trait EnumTrait
{
  public static function names(): array
  {
    return array_column(self::cases(), 'name');
  }

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }

  public static function array(): array
  {
    return array_combine(self::names(), self::values());
  }

  public static function random(): string
  {
    return self::values()[array_rand(self::values())];
  }

  public static function randomArr(int $maxLength = 3): array
  {
    $randomValues = array_rand(array_flip(self::values()), mt_rand(1, $maxLength));
    return is_array($randomValues) ? $randomValues : [$randomValues];
  }
}