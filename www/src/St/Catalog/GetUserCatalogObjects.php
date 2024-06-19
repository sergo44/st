<?php

namespace St\Catalog;

use PDO;
use St\CatalogObject;
use St\Db;
use St\IReadDb;

class GetUserCatalogObjects implements IReadDb
{
    /**
     * Идентификатор пользователя
     * @var int
     */
    protected int $user_id;
    /**
     * Идентификатор PDO
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор объекта
     * @param int $user_id
     * @param PDO|null $dbh
     */
    public function __construct(int $user_id, ?PDO $dbh = null)
    {
        $this->user_id = $user_id;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает объекты пользователя
     * @return CatalogObject[]
     */
    public function getCatalogObjects(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects where user_id = :user_id");
        $sth->execute(array(
            ":user_id" => $this->user_id
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS |  PDO::FETCH_PROPS_LATE, CatalogObject::class);
    }
}