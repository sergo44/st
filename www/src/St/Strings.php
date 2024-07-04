<?php
/**
 * Файл содержит статичные функции облегчающие работу со строками
 */
namespace St;

final class Strings
{
    /**
     * Выполняет функцию htmlspecialchars с установленной кодировкой
     * @param mixed $string
     * @return string
     */
    public static function escape(mixed $string): string
    {
        return htmlspecialchars(string: $string, encoding: 'UTF-8');
    }
}