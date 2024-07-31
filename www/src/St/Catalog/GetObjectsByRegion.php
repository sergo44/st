<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\Db;
use St\IReadDb;
use St\Region;

class GetObjectsByRegion implements IReadDb
{
    /**
     * Регион, для которого выводятся объекты
     * @var Region
     */
    protected Region $region;
    /**
     * Объект PDO
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param Region $region
     * @param PDO|null $dbh
     */
    public function __construct(Region $region, ?\PDO $dbh = null)
    {
        $this->region = $region;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает объекты
     * @return CatalogObject[]
     */
    public function getObjects(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects where region_id = :region_id");
        $sth->execute(array(
            ":region_id" => $this->region->getRegionId()
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, CatalogObject::class);
    }
}