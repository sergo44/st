<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\City;
use St\Db;
use St\IReadDb;

class GetObjectsByCity implements IReadDb
{
    /**
     * Город, для которого выводятся объекты
     * @var City
     */
    protected City $city;
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;

    public function __construct(City $city, ?PDO $dbh = null)
    {
        $this->city = $city;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает объекты
     * @return CatalogObject[]
     */
    public function getObjects(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects where city_id = :city_id order by posted_datetime desc");
        $sth->execute(array(
            ":city_id" => $this->city->getCityId()
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, CatalogObject::class);
    }
}