<?php

namespace St\Utils;

use St\ApplicationError;

class TemplatesUtils
{
    /**
     * Возвращает URI с временем модификации
     * @param string $path
     * @return string
     * @throws ApplicationError
     */
    public static function require_js(string $path): string
    {
        $full_path = ST_PUBLIC_WEB_PATH . $path;

        if (!file_exists($full_path) || !is_readable($full_path)) {
            throw new ApplicationError(sprintf("File %s not found in web directory (%s)", $path, $full_path));
        }

        return sprintf("%s?v=%d", $path, filemtime($full_path));
    }
}