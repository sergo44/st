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
     * Объект PDO
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает достопримечательности
     * @return Sight[]
     */
    public function GetSights(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM sights WHERE status = :status ORDER BY created_datetime_utc DESC");
        $sth->execute(array(
            ":status" => SightStatusEnum::Approved->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Sight::class);
    }
}