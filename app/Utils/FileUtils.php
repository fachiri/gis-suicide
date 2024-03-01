<?php

namespace App\Utils;

class FileUtils
{
  public static function formatSizeUnits($bytes)
  {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
  }
}
