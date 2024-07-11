<?php

namespace St;

use Generator;

class Fs
{
    /**
     * Создаем директорию, согласно принятой маски файлов
     * @param $directory
     * @return bool
     */
    public static function mkdir($directory): bool
    {
        $result = mkdir($directory, 0777 & ~ST_DEFAULT_UMASK);
        clearstatcache(true);
        return $result;
    }

    /**
     * Создание директории рекрусивно (аналогично mkdir -p /some/long/directory)
     * @param $path
     * @return bool
     */
    public static function mkdir_recursive($path): bool
    {
        $increment = 1;
        $path = str_replace(DIRECTORY_SEPARATOR,'/', $path);
        $directories = explode('/', $path);

        do {

            $directory = implode(DIRECTORY_SEPARATOR, array_slice($directories, 0, $increment));

            if (!$directory) {
                continue;
            }

            if (!file_exists($directory)) {
                if (!self::mkdir($directory)) {
                    return false;
                }
            }
        } while (++$increment <= sizeof($directories));

        clearstatcache(true);

        return true;
    }

    /**
     * Директория, которую необходимо очистить
     * @param string $directory
     * @param int $expired_sec
     * @return void
     */
    public static function unlink_old_files(string $directory, int $expired_sec): void
    {
        if (!file_exists($directory) && !is_dir($directory)) {
            return;
        }

        $traversal = self::get_tree_traversal($directory);
        foreach ($traversal as $filename) {
            if (file_exists($filename) && is_file($filename)) {
                $mtime = filemtime($filename);
                if ($mtime < (time() - $expired_sec)) {
                    unlink($filename);
                }
            }
        }

        clearstatcache(true, true);
    }

    /**
     * Возвращает все директории, используя генераторы
     * @param string $dir_name
     * @param int $max_depth
     * @param int $cur_depth
     * @return Generator
     */
    public static function get_tree_traversal(string $dir_name, int $max_depth = -1, int $cur_depth = 0): Generator
    {
        if ($max_depth === -1 || $cur_depth < $max_depth) {
            $handle = opendir($dir_name);

            if ($handle) {
                try {
                    while (($filename = readdir($handle)) !== false) {
                        if ($filename !== "." && $filename !== "..") {
                            yield $dir_name . $filename;

                            if (is_dir($dir_name . $filename)) {
                                $sub_traversal = self::get_tree_traversal($dir_name . $filename . DIRECTORY_SEPARATOR, $max_depth, ($cur_depth + 1));
                                foreach ($sub_traversal as $sub_filename) {
                                    yield $sub_filename;
                                }
                            }
                        }
                    }
                } finally {
                    closedir($handle);
                }
            }
        }
    }

    /**
     * Удаляет оригинальный файл и миниатюры из файловой системы
     * @param string $dirname
     * @param string $purge_image_filename
     * @return void
     */
    public static function purge_thumbs(string $dirname, string $purge_image_filename): void
    {
        $files = scandir($dirname);

        foreach ($files as $file) {
            $path = sprintf("%s/%s", $dirname, $file);
            if ($file !== "." && $file !== ".." and is_dir($path) && is_executable($path)) {
                self::purge_thumbs($path, $purge_image_filename);
            } elseif (is_file($path) && basename($path) === $purge_image_filename ) {
                unlink($path);
            }
        }
    }
}