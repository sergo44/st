<?php

namespace St\Cities;

use PDO;
use St\City;
use St\Db;
use St\IReadDb;
use St\IUseRedis;

class GetRegionCities implements IReadDb, IUseRedis
{
    /**
     * Регион, для которого отображается населенные пункты
     * @var int
     */
    protected int $region_id;
    /**
     * Объект PDO который используется для выполнения запроса к СУБД
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param int $region_id
     * @param PDO|null $dbh
     */
    public function __construct(int $region_id, ?PDO $dbh = null)
    {
        $this->region_id = $region_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает города
     * @return City[]
     */
    public function getCities(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM cities WHERE region_id = :region_id ORDER BY name");

        $sth->execute(array(
            ":region_id" => $this->region_id
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, City::class);
    }
}