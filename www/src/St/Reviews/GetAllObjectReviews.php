<?php

namespace St\Reviews;

use PDO;
use St\Db;
use St\IReadDb;
use St\Review;
use St\ReviewStatusesEnum;

class GetAllObjectReviews implements IReadDb
{
    /**
     * Идентификатор объекта
     * @var int
     */
    protected int $object_id;
    /**
     * Объект PDO который будет использоваться для соединения с СУБД
     * @var PDO|null
     */
    protected ?PDO $dbh;


    /**
     * Конструктор класса
     * @param int $object_id
     * @param PDO|null $dbh
     */
    public function __construct(int $object_id, ?PDO $dbh = null)
    {

        $this->dbh = $dbh ?: Db::getWritePDOInstance();
        $this->object_id = $object_id;
    }

    /**
     * Возвращает отзывы, которые находятся в статусе ожидания
     * @return Review[]
     */
    public function getReviews(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM reviews where object_id = :object_id order by publish_datetime_utc");
        $sth->execute(array(
            "object_id" => $this->object_id
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Review::class);
    }
}