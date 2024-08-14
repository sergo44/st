<?php

namespace St\Sights;

use PDO;
use St\Db;
use St\IReadDb;

class GetPopularSights implements IReadDb
{
    /**
     * Количество популярных достопримечательностей
     * @var int
     */
    protected int $limit;
    /**
     * Объект PDO для работы с базой данных
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param int $limit
     * @param PDO|null $dbh
     */
    public function __construct(int $limit, ?PDO $dbh = null)
    {
        $this->limit = $limit;
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает достопримечательности
     * @return Sight[]
     */
    public function getSights(): array
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */sprintf("
                SELECT sights.* FROM sights 
                JOIN sights_images on sights_images.sight_id = sights.sight_id 
                WHERE status = :status 
                GROUP BY sights.sight_id
                ORDER BY RAND()
                LIMIT 0, %u
                ", $this->limit));

        $sth->execute(array(
            ":status" => SightStatusEnum::Approved->name
        ));

        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Sight::class);

        return $sth->fetchAll();
    }
}