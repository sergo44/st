<?php

namespace St;

use DateTime;
use DateTimeZone;

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
            return new DateTime("now", new DateTimeZone($time_zone));
        } catch (\Exception $e) {
            return new DateTime();
        }
    }

    /**
     * Создает объект TimeZone
     * @param string $publish_datetime_utc
     * @param string $tz_to
     * @param string $tz_from
     * @return DateTime|null
     */
    public static function create(string $publish_datetime_utc, string $tz_to = "UTC", string $tz_from = "UTC"): ?DateTime
    {
        if (!$publish_datetime_utc) {
            return null;
        }

        try {

            $datetime = new DateTime($publish_datetime_utc, new DateTimeZone($tz_from));

            if ($tz_from !== $tz_to) {
                $datetime->setTimezone(new DateTimeZone($tz_to));
            }

            return $datetime;


        } catch (\Exception $e) {
            return null;
        }
    }
}