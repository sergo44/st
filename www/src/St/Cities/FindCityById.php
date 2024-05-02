<?php

namespace St\Cities;

use PDO;
use St\ApplicationError;
use St\City;
use St\Db;
use St\IReadDb;

class FindCityById implements IReadDb
{
    /**
     * Идентификатор города
     * @var int
     */
    protected int $city_id;
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * @param int $city_id
     * @param PDO|null $dbh
     */
    public function __construct(int $city_id, ?PDO $dbh = null)
    {
        $this->city_id = $city_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Получаем город
     * @throws ApplicationError
     */
    public function getCity(): ?City
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240501-1316 */ * FROM cities where city_id = :city_id");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, City::class);

        $sth->execute(array(
            ":city_id" => $this->city_id
        ));

        if ($sth->rowCount() === 0) {
            return null;
        } elseif ($sth->rowCount() === 1) {
            return $sth->fetch();
        } else {
            throw new ApplicationError(sprintf("Multiple cities selected from database use id %s", $this->city_id));
        }
    }
}