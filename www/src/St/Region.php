<?php

namespace St;

use PDO;
use St\Regions\FindRegionById;

class Region implements IUseRedis, \JsonSerializable
{
    /**
     * Идентификатор региона
     * @var int|null
     */
    protected ?int $region_id;
    /**
     * Идентификатор страны,
     * к которому принадлежит регион
     * @var int
     */
    protected int $country_id;
    /**
     * Наименование региона
     * @var string
     */
    protected string $name;

    /**
     * Магический метод __sleep(), используется для обозначения свойств,
     * которые необходимо при сериализации
     * @return string[]
     */
    public function __sleep()
    {
        return array(
            "region_id",
            "country_id",
            "name"
        );
    }

    /**
     * Возвращает свойства, которые используются для сериализации
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array(
            "region_id" => $this->region_id,
            "country_id" => $this->country_id,
            "name" => $this->name
        );
    }

    /**
     * Получает регион по идентификатору. Если объекта не существует, то
     * будет возвращен новый объект
     * @throws ApplicationError
     */
    public static function get(int $region_id, bool $pop_cache = true, bool $push_cache = true): Region
    {
        $key = sprintf("geo:region:%u", $region_id);

        if ($pop_cache) {
            try {
                $cached_region = RedisHelper::getInstance()->getValue($key);
                if ($cached_region) {
                    return unserialize($cached_region);
                }
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        $users = new FindRegionById($region_id);
        $region = $users->getRegion();

        if (!$region) {
            $region = new Region();
        }

        if ($push_cache) {
            try {
                RedisHelper::getInstance()->setValue($key, serialize($region));
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        return $region;
    }

    /**
     * Возвращает region_id
     * @return int|null
     * @see region_id
     */
    public function getRegionId(): ?int
    {
        return $this->region_id;
    }

    /**
     * Устанавливает region_id
     * @param int|null $region_id
     * @return Region
     * @see region_id
     */
    public function setRegionId(?int $region_id): Region
    {
        $this->region_id = $region_id;
        return $this;
    }

    /**
     * Возвращает country_id
     * @return int
     * @see country_id
     */
    public function getCountryId(): int
    {
        return $this->country_id;
    }

    /**
     * Устанавливает country_id
     * @param int $country_id
     * @return Region
     * @see country_id
     */
    public function setCountryId(int $country_id): Region
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * Возвращает name
     * @return string
     * @see name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Устанавливает name
     * @param string $name
     * @return Region
     * @see name
     */
    public function setName(string $name): Region
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает URL для хлебных крошек
     * @return string
     */
    public function getBreadcrumbsUrl(): string
    {
        return match($this->region_id) {
            1 => "/Catalog/Objects/Irkutsk/",
            2 => "/Catalog/Objects/UlanUde/"
        };
    }


}