<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\CatalogObjectType;
use St\Db;
use St\IReadDb;

class GetObjectsByType implements IReadDb
{
    /**
     * Тип объектов для отображения
     * @var CatalogObjectType
     */
    protected CatalogObjectType $object_type;
    /**
     * Объект PDO
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор объекта
     * @param CatalogObjectType $object_type
     * @param PDO|null $dbh
     */
    public function __construct(CatalogObjectType $object_type, ?PDO $dbh = null)
    {
        $this->object_type = $object_type;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Возвращает объекты каталога
     * @return CatalogObject[]
     */
    public function getCatalogObjects(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects where object_type = :object_type");
        $sth->execute(array(
            ":object_type" => $this->object_type->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, CatalogObject::class);
    }
}