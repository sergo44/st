<?php

namespace St;

use PDO as PDO;
use St\Db\ProfileRow;

class Db
{
    /**
     * PDO Write
     * @var PDO|null
     */
    protected static PDO|null $write = null;

    /**
     * Возвращает данные по выполненным SQL запросам
     * @see https://mariadb.com/kb/en/show-profile/
     * @param PDO|null $dbh
     * @return ProfileRow[]
     */
    public static function getDbProfiles(?\PDO $dbh = null): array
    {
        if (!isset($dbh)) {
            $dbh = self::getReadPDOInstance();
        }

        $sth = $dbh->query("SHOW PROFILES");
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, ProfileRow::class);
    }

    /**
     * Возвращает созданный экземпляр PDO
     * @return PDO
     */
    public static function getWritePDOInstance(): PDO
    {
        if (!isset(self::$write)) {
            self::$write = new PDO(
                sprintf("mysql:host=%s;port=3306;dbname=%s;charset=UTF8", ST_DB_HOST, ST_DB_NAME),
                ST_DB_USER,
                ST_DB_PASS,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8",
                    PDO::ATTR_EMULATE_PREPARES => (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION)
                )
            );

            self::$write->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION) {
                self::$write->query("SET profiling = 1;");
                self::$write->query("SET @@profiling_history_size = 100;");
            }

            /* if (defined("ST_DEVELOPMENT_VERSION")) {
                self::$write->query("SET sql_mode=(SELECT
                    REPLACE(
                        REPLACE(
                            REPLACE(@@sql_mode,
                            'ONLY_FULL_GROUP_BY',''
                            ),
                        'NO_ZERO_IN_DATE',
                        ''),
                    'NO_ZERO_DATE',
                    ''
                    )
                )");

            } */
        }

        return self::$write;
    }

    /**
     * Возвращает объект PDO для чтения из базы данных
     * @return PDO
     */
    public static function getReadPDOInstance(): PDO
    {
        return self::getWritePDOInstance();
    }
}