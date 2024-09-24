<?php

namespace St;

class Utils
{
    /**
     * Применяет функцию PHP
     * @param string $string
     * @return string
     */
    public static function escape_html(string $string): string
    {
        return htmlspecialchars(string: $string, encoding: "UTF-8");
    }

    /**
     * Возвращает url сайта
     * @return string
     */
    public static function site_url(): string
    {
        $return = "http";

        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            $return .= "s";
        }

        $return .= "://" . ST_HOST;

        return $return;
    }
}