<?php

namespace St\Reviews;

use PDO;
use St\Db;
use St\IReadDb;
use St\Review;
use St\ReviewStatusesEnum;

class GetWaitReviews implements IReadDb
{
    /**
     * Объект PDO который будет использоваться для соединения с СУБД
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?: Db::getWritePDOInstance();
    }

    /**
     * Возвращает отзывы, которые находятся в статусе ожидания
     * @return Review[]
     */
    public function getReviews(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM reviews where status = :status order by publish_datetime_utc");
        $sth->execute(array(
            "status" => ReviewStatusesEnum::Wait->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Review::class);
    }
}