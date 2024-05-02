<?php

namespace St\Regions;

use PDO;
use St\ApplicationError;
use St\Db;
use St\IReadDb;
use St\Region;

class FindRegionById implements IReadDb
{
    protected int $region_id;
    protected ?PDO $dbh;

    public function __construct(int $region_id, ?PDO $dbh = null)
    {
        $this->region_id = $region_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает регион
     * @throws ApplicationError
     */
    public function getRegion(): ?Region
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240501-1421 */ * FROM regions where region_id = :region_id");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Region::class);

        $sth->execute(array(
            ":region_id" => $this->region_id
        ));

        if ($sth->rowCount() === 0) {
            return null;
        } elseif ($sth->rowCount() === 1) {
            return $sth->fetch();
        } else {
            throw new ApplicationError(sprintf("Multiple region selected from database use id %s", $this->region_id));
        }
    }
}