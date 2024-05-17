<?php

namespace St;

use St\Countries\FindCountryById;

class Country implements IUseRedis
{
    /**
     * Идентификатор страны
     * @var int|null
     */
    protected ?int $country_id = null;
    /**
     * Код страны
     * @var string
     */
    protected string $code = "";
    /**
     * Наименование страны
     * @var string
     */
    protected string $name = "";

    public function __sleep()
    {
        return array(
            "country_id",
            "code",
            "name"
        );
    }

    /**
     * Получаем страну по идентификатору
     * Если страна не найдена, будет возвращен новый объект
     *
     * @param int $country_id
     * @param bool $pop_cache
     * @param bool $push_cache
     * @return Country
     * @throws ApplicationError
     *@todo Move To Redis Helper
     */
    public static function get(int $country_id, bool $pop_cache = true, bool $push_cache = true): Country
    {
        $key = sprintf("geo:country:%u", $country_id);

        if ($pop_cache) {
            try {
                $cached_country = RedisHelper::getInstance()->getValue($key);
                if ($cached_country) {
                    return unserialize($cached_country);
                }
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        $countries = new FindCountryById($country_id);
        $country = $countries->getCountry();

        if (!$country) {
            $country = new Country();
        }

        if ($push_cache) {
            try {
                RedisHelper::getInstance()->setValue("country:{$country_id}", serialize($country));
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        return $country;
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
     * @return Country
     * @see country_id
     */
    public function setCountryId(int $country_id): Country
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * Возвращает code
     * @return string
     * @see code
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Устанавливает code
     * @param string $code
     * @return Country
     * @see code
     */
    public function setCode(string $code): Country
    {
        $this->code = $code;
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
     * @return Country
     * @see name
     */
    public function setName(string $name): Country
    {
        $this->name = $name;
        return $this;
    }

}