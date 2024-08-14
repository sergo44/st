<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\IReadDb;

class GetWaitSights implements IReadDb
{
    /**
     * Объект PDO для работы с базой данных
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает объекты
     * @return Sight[]
     */
    public function getSights(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM sights where status = :status order by created_datetime_utc");
        $sth->execute(array(
            ":status" => SightStatusEnum::Wait->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Sight::class);
    }

}