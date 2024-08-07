<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\IReadDb;

class GetSightImages implements IReadDb
{
    /**
     * Объект достопримечательности
     * @var Sight
     */
    protected Sight $sight;
    /**
     * Объект PDO
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param Sight $sight
     * @param PDO|null $dbh
     */
    public function __construct(Sight $sight, ?PDO $dbh = null)
    {
        $this->sight = $sight;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает изображения
     * @return SightImage[]
     */
    public function getImages(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM sights_images where sight_id = :sight_id");
        $sth->execute(array(
            ":sight_id" => $this->sight->getSightId()
        ));
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, SightImage::class);
    }
}