<?php

namespace St\Countries;

use PDO;
use St\ApplicationError;
use St\Country;
use St\Db;
use St\IReadDb;
use St\IUseRedis;
use St\RedisHelper;

class GetVisibleCountries implements IReadDb, IUseRedis
{
    /**
     * Объект PDO для получения данных
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * Конструктор объекта
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает страны для отображения
     * @return Country[]
     * @throws ApplicationError
     */
    public function getCountries(): array
    {
        $countries = array();

        $key = "geo:countries:visible";

        try {

            $cached = RedisHelper::getInstance()->getValue($key);
            if ($cached) {
                return unserialize($cached);
            }

        } catch (\RedisException $e) {
            if (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION) {
                throw new ApplicationError("Redis failed %s", $e->getMessage());
            }
        }

        $sth = $this->dbh->query(/** @lang MariaDB */"SELECT * FROM countries order by name");
        $countries = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Country::class);

        try {

            RedisHelper::getInstance()->setValue($key, serialize($countries));

        } catch (\RedisException $e) {
            if (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION) {
                throw new ApplicationError("Redis failed %s", $e->getMessage());
            }
        }

        return $countries;
    }


}