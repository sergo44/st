<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\CatalogObjectsStatusesEnum;
use St\Db;

class GetObjectsByStatus
{
    /**
     * Статус объекта
     * @var CatalogObjectsStatusesEnum
     */
    protected CatalogObjectsStatusesEnum $status;
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * Конструктор класса
     * @param CatalogObjectsStatusesEnum $status
     * @param PDO|null $dbh
     */
    public function __construct(CatalogObjectsStatusesEnum $status, ?PDO $dbh = null)
    {
        $this->status = $status;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Метод возвращает объекты по статусам
     * @return CatalogObject[]
     */
    public function getObjects(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects WHERE status = :status");

        $sth->execute(array(
            ":status" => $this->status->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, CatalogObject::class);
    }
}