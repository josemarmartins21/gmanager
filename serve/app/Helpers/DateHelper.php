<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper 
{
    public static function diffForHumans(string $date)
    {
        $date = Carbon::parse($date);

        return $date->diffForHumans();
    }

    public static function currentExtendedDate()
    {
        return Carbon::now()
        ->locale('pt_BR')
        ->translatedFormat('l, d \\d\\e F \\d\\e Y');
    }

    public static function remainingDays(int $days): string
    {
        if ($days >= 15) {
            return 'green';
        }

        if ($days < 15 && $days > 5) {
            return 'yellow';
        }

        return 'red';
    }
    
}