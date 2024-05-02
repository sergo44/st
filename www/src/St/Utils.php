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
}