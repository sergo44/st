<?php

namespace St;

use DateTime;

class DateTimeHelper
{
    /**
     * Возвращает текущее время
     * @param string $time_zone
     * @return DateTime
     */
    public static function now(string $time_zone = "UTC"): DateTime
    {
        try {
            return new DateTime("now", new \DateTimeZone($time_zone));
        } catch (\Exception $e) {
            return new DateTime();
        }
    }
}