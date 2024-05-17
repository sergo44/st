<?php

namespace St;

use St\Cities\FindCityById;

class City implements \JsonSerializable
{
    /**
     * Идентификатор города
     * @var int|null
     */
    protected ?int $city_id = null;
    /**
     * Идентификатор страны
     * @var int
     */
    protected int $country_id = 0;
    /**
     * Идентификатор региона
     * @var int
     */
    protected int $region_id = 0;
    /**
     * Наименование города
     * @var string
     */
    protected string $name = "";

    /**
     * Магический метод __sleep(),
     * используется при сериализации объекта
     * @return string[]
     */
    public function __sleep()
    {
        return array(
            "city_id",
            "country_id",
            "region_id",
            "name"
        );
    }

    /**
     * Подготавливает данные для сериализации объекта
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "city_id" => $this->city_id,
            "country_id" => $this->country_id,
            "region_id" => $this->region_id,
            "name" => $this->name
        );
    }

    /**
     * Получаем город по идентификатору. Если объект не существует,
     * будет возвращен новый объект
     *
     * @param int $city_id
     * @param bool $pop_cache
     * @param bool $push_cache
     * @return City
     * @throws ApplicationError
     * @todo Move To Redis Helper
     */
    public static function get(int $city_id, bool $pop_cache = true, bool $push_cache = true): City
    {
        $key = sprintf("geo:city:%u", $city_id);

        if ($pop_cache) {
            try {
                $cached_city = RedisHelper::getInstance()->getValue($key);
                if ($cached_city) {
                    return unserialize($cached_city);
                }
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        $users = new FindCityById($city_id);
        $city = $users->getCity();

        if (!$city) {
            $city = new City();
        }

        if ($push_cache) {
            try {
                RedisHelper::getInstance()->setValue($key, serialize($city));
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        return $city;
    }
    /**
     * Возвращает city_id
     * @return int
     * @see city_id
     */
    public function getCityId(): int
    {
        return $this->city_id;
    }

    /**
     * Устанавливает city_id
     * @param int $city_id
     * @return City
     * @see city_id
     */
    public function setCityId(int $city_id): City
    {
        $this->city_id = $city_id;
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
     * @return City
     * @see country_id
     */
    public function setCountryId(int $country_id): City
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * Возвращает region_id
     * @return int
     * @see region_id
     */
    public function getRegionId(): int
    {
        return $this->region_id;
    }

    /**
     * Устанавливает region_id
     * @param int $region_id
     * @return City
     * @see region_id
     */
    public function setRegionId(int $region_id): City
    {
        $this->region_id = $region_id;
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
     * @return City
     * @see name
     */
    public function setName(string $name): City
    {
        $this->name = $name;
        return $this;
    }
}