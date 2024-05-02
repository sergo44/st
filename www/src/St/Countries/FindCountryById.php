<?php

namespace St\Countries;

use PDO;
use St\ApplicationError;
use St\Country;
use St\Db;
use St\IReadDb;

class FindCountryById implements IReadDb
{
    /**
     * Идентификатор страны, по которому идет поиск в базе данных
     * @var int
     */
    protected int $country_id;
    /**
     * Объект PDO для работы с базой данных
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * Конструктор объекта
     * @param int $country_id
     * @param PDO|null $dbh
     */
    public function __construct(int $country_id, ?PDO $dbh = null)
    {
        $this->country_id = $country_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает страну
     * @throws ApplicationError
     */
    public function getCountry(): Country|null
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240501-1357 */ * FROM countries where country_id = :country_id");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Country::class);

        $sth->execute(array(
            ":country_id" => $this->country_id
        ));

        if ($sth->rowCount() === 0) {
            return null;
        } elseif ($sth->rowCount() === 1) {
            return $sth->fetch();
        } else {
            throw new ApplicationError(sprintf("Multiple countries selected from database use id %s", $this->country_id));
        }
    }
}