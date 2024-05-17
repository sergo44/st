<?php

namespace St\Cities;

use PDO;
use St\ApplicationError;
use St\City;
use St\Db;
use St\IReadDb;
use St\IUseRedis;
use St\RedisHelper;
use St\Region;

class GetRegionCities implements IReadDb, IUseRedis
{
    /**
     * Регион, для которого отображается населенные пункты
     * @var int
     */
    protected int $region_id;
    /**
     * Объект PDO который используется для выполнения запроса к СУБД
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param int $region_id
     * @param PDO|null $dbh
     */
    public function __construct(int $region_id, ?PDO $dbh = null)
    {
        $this->region_id = $region_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает города
     * @return City[]
     * @throws ApplicationError
     */
    public function getCities(): array
    {
        $cities = array();

        try {
            $key = sprintf("geo:countries:%u:regions:%u:cities:all", Region::get($this->region_id)->getCountryId(), $this->region_id);

            $cached = RedisHelper::getInstance()->getValue($key);
            if ($cached) {
                return unserialize($cached);
            }

            $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT * FROM cities WHERE region_id = :region_id ORDER BY name");
            $sth->execute(array(
                ":region_id" => $this->region_id
            ));

            $cities = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, City::class);

            RedisHelper::getInstance()->setValue($key, serialize($cities));

        } catch (\RedisException $e) {
            if (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION) {
                throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
            }
        }

        return $cities;
    }
}