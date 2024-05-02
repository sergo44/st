<?php

namespace St\Countries;

use PDO;
use St\Country;
use St\Db;
use St\IReadDb;
use St\IUseRedis;

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
     */
    public function getCountries(): array
    {
        // @todo Redis cache need
        $sth = $this->dbh->query(/** @lang MariaDB */"SELECT * FROM countries order by name");
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Country::class);
    }


}