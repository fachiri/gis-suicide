<?php

namespace App\Utils;

use App\Constants\UserRole;
use App\Models\Criteria;

class GetUtils
{
  public static function getAgeClass($age)
  {
    $_USIA_NON_PRODUKTIF = Criteria::where('code', 'D3')->first()->id;
    $_USIA_MUDA = Criteria::where('code', 'D1')->first()->id;
    $_USIA_PRODUKTIF = Criteria::where('code', 'D2')->first()->id;

    // Jika usia antara 15 dan 24 tahun, kembalikan $_USIA_MUDA
    if ($age >= 15 && $age <= 24) {
      return $_USIA_MUDA;
    }

    // Jika usia antara 25 dan 59 tahun, kembalikan $_USIA_PRODUKTIF
    if ($age >= 25 && $age <= 59) {
      return $_USIA_PRODUKTIF;
    }

    // Jika tidak, kembalikan $_USIA_NON_PRODUKTIF
    return $_USIA_NON_PRODUKTIF;
  }
}
