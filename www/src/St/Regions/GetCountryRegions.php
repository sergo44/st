<?php

namespace St\Regions;

use PDO;
use St\ApplicationError;
use St\Db;
use St\IReadDb;
use St\IUseRedis;
use St\RedisHelper;
use St\Region;

class GetCountryRegions implements IGetRegions, IReadDb, IUseRedis
{
    /**
     * Идентификатор страны, для которой нужно выгрузить страны
     * @var int
     */
    protected int $country_id;
    /**
     * Объект PDO
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * @param int $country_id
     * @param PDO|null $dbh
     */
    public function __construct(int $country_id, ?PDO $dbh = null)
    {
        $this->country_id = $country_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает регионы
     * @return Region[]
     * @throws ApplicationError
     */
    public function getRegions(): array
    {
        $regions = array();

        try {

            $key = sprintf("geo:countries:%u:regions:all", $this->country_id);

            $cached = RedisHelper::getInstance()->getValue($key);
            if ($cached) {
                return unserialize($cached);
            }

            $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240502-1011 */ * FROM regions where country_id = :country_id ORDER BY name");
            $sth->execute(array(
                ":country_id" => $this->country_id
            ));

            $regions = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Region::class);

            RedisHelper::getInstance()->setValue($key, serialize($regions));


        } catch (\RedisException $e) {
            if (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION) {
                throw new ApplicationError("Redis failed: %s", $e->getMessage());
            }
        }

        return $regions;
    }
}