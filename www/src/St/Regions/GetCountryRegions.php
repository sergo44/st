<?php

namespace St\Regions;

use PDO;
use St\Db;
use St\IReadDb;
use St\IUseRedis;
use St\Region;

class GetCountryRegions implements IGetRegions, IReadDb, IUseRedis
{
    /**
     * Идентификатор страны, для которой нужно выгрузить страны
     * @var int
     */
    protected int $country_id;
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * @param int $country_id
     * @param PDO|null $dbh
     */
    public function __construct(int $country_id, ?PDO $dbh = null)
    {
        $this->country_id = $country_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает регионы
     * @return Region[]
     */
    public function getRegions(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240502-1011 */ * FROM regions where country_id = :country_id ORDER BY name");

        $sth->execute(array(
            ":country_id" => $this->country_id
        ));


        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Region::class);
    }
}