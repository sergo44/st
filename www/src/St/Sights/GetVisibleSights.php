<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\IReadDb;

class GetVisibleSights implements IReadDb
{
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;
    /**
     * Фильтр достопримечательностей
     * @var SightFilter|null
     */
    protected ?SightFilter $filter = null;

    /**
     * Объект PDO
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает filter
     * @return SightFilter|null
     * @see filter
     */
    public function getFilter(): ?SightFilter
    {
        return $this->filter;
    }

    /**
     * Устанавливает filter
     * @param SightFilter|null $filter
     * @return GetVisibleSights
     * @see filter
     */
    public function setFilter(?SightFilter $filter): GetVisibleSights
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * Возвращает достопримечательности
     * @return Sight[]
     */
    public function getSights(): array
    {
        $where_1 = $this->filter?->getRegionsSQLWhere("region_id") ?: "";
        $where_2 = $this->filter?->getCitiesSQLWhere("city_id") ?: "";

        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            SELECT 
                * 
            FROM 
                sights 
            WHERE 
                status = :status 
                {$where_1}
                {$where_2}
            ORDER BY 
                created_datetime_utc DESC
            ");


        $sth->execute(array(
            ":status" => SightStatusEnum::Approved->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Sight::class);
    }
}