<?php

namespace App\Helpers;

use DateTime;

class Formatter
{
  public static function formatToYmd(string $date)
  {
    $datetime = DateTime::createFromFormat('d-m-Y', $date); 
    $formatted_date = $datetime->format('Y-m-d');
    return $formatted_date;
  }
}