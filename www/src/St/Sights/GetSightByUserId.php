<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\IReadDb;

class GetSightByUserId implements IReadDb
{
    /**
     * Идентификатор пользователя, для которого выводятся данные
     * @var int
     */
    protected int $user_id;
    /**
     * Объект PDO для работы с базой данных
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param int $user_id
     * @param PDO|null $dbh
     */
    public function __construct(int $user_id, ?PDO $dbh = null)
    {

        $this->user_id = $user_id;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает достопримечательности пользователя
     * @return Sight[]
     */
    public function getSights(): array
    {
        $sth = $this->dbh->prepare(/** lang MariaDB */"SELECT * FROM sights where user_id = :user_id ORDER BY created_datetime_utc DESC");
        $sth->execute(array(
            ":user_id" => $this->user_id
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Sight::class);
    }
}