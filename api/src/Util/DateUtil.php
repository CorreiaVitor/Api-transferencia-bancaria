<?php

namespace App\Util;

class DateUtil
{

    public static function setBrazilTimezone() : void
    {
        date_default_timezone_set('America/Sao_Paulo'); 
    }

    public static function currentDate() : string 
    {
        self::setBrazilTimezone();
        return date('Y-m-d');
    }

    public static function currentDateTime() : string
    {
        self::setBrazilTimezone();
        return date('Y-m-d H:i');
    }

    public static function currentBrazilDate() : string
    {
        self::setBrazilTimezone();
        return date('d/m/Y');
    }

    public static function currentTime() : string
    {
        self::setBrazilTimezone();
        return date('H:i');    
    }

}