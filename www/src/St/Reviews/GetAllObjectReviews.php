<?php

namespace St\Reviews;

use PDO;
use St\Db;
use St\IReadDb;
use St\Review;

class GetAllObjectReviews implements IReadDb
{
    /**
     * Идентификатор объекта
     * @var int
     */
    protected int $object_id;
    /**
     * Тип объекта
     * @var ReviewObjectTypesEnum
     */
    protected ReviewObjectTypesEnum $type;
    /**
     * Объект PDO который будет использоваться для соединения с СУБД
     * @var PDO|null
     */
    protected ?PDO $dbh;


    /**
     * Конструктор класса
     * @param int $object_id
     * @param ReviewObjectTypesEnum $type
     * @param PDO|null $dbh
     */
    public function __construct(int $object_id, ReviewObjectTypesEnum $type, ?PDO $dbh = null)
    {
        $this->object_id = $object_id;
        $this->type = $type;
        $this->dbh = $dbh ?: Db::getWritePDOInstance();
    }

    /**
     * Возвращает отзывы, которые находятся в статусе ожидания
     * @return Review[]
     */
    public function getReviews(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM reviews where object_id = :object_id && object_type = :object_type order by publish_datetime_utc");
        $sth->execute(array(
            ":object_id" => $this->object_id,
            ":object_type" => $this->type->name
        ));

        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Review::class);
    }
}