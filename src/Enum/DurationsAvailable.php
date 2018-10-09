<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 09/10/2018
 * Time: 10:45
 */

namespace App\Enum;


class DurationsAvailable
{
    protected static $durationsTypes = [
        'day',
        'halfday'
    ];

    public static function getAvailableDurations() {
        return self::$durationsTypes;
    }

}