<?php

namespace St\Catalog;

use St\Catalog\CallableControllers\Get;
use St\CatalogObject;
use St\CatalogObjectsStatusesEnum;
use St\Db;
use St\IReadDb;

class GetWaitCatalogObjects implements IReadDb
{
    /**
     * Объект PDO
     * @var \PDO
     */
    protected \PDO $dbh;

    /**
     * Конструктор класса
     * @param ?\PDO|null $dbh
     */
    public function __construct(?\PDO $dbh = null)
    {
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает объекты
     * @return CatalogObject[]
     */
    public function getObjects(): array
    {
        return (new GetObjectsByStatus(CatalogObjectsStatusesEnum::Wait))->getObjects();
    }
}