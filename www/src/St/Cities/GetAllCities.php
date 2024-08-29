<?php

namespace St\Cities;

use PDO;
use St\ApplicationError;
use St\City;
use St\Db;
use St\IReadDb;
use St\IUseRedis;
use St\RedisHelper;
use St\Region;

class GetAllCities implements IReadDb, IUseRedis
{
    /**
     * Объект PDO который используется для выполнения запроса к СУБД
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает города
     * @return City[]
     */
    public function getCities(): array
    {
        $sth = $this->dbh->query(/** @lang MariaDB */"SELECT * FROM cities ORDER BY region_id, name");
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, City::class);
    }
}