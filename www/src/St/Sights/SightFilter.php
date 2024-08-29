<?php

namespace St\Sights;

use PDO;
use St\Db;

class SightFilter
{
    /**
     * Регионы для поиска
     * @var int[]
     */
    protected array $region_ids = array();
    /**
     * Города
     * @var int[]
     */
    protected array $city_ids = array();
    /**
     * Объект PDO для работы с базой данных
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * Конструктор класса
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает region_ids
     * @return array
     * @see region_ids
     */
    public function getRegionIds(): array
    {
        return $this->region_ids;
    }

    /**
     * Устанавливает region_ids
     * @param array $region_ids
     * @return SightFilter
     * @see region_ids
     */
    public function setRegionIds(array $region_ids): SightFilter
    {
        $this->region_ids = $region_ids;
        return $this;
    }

    /**
     * Возвращает city_ids
     * @return array
     * @see city_ids
     */
    public function getCityIds(): array
    {
        return $this->city_ids;
    }

    /**
     * Устанавливает city_ids
     * @param array $city_ids
     * @return SightFilter
     * @see city_ids
     */
    public function setCityIds(array $city_ids): SightFilter
    {
        $this->city_ids = $city_ids;
        return $this;
    }

    /**
     * Возвращает where для SQL
     * @param string $column
     * @param string $operand
     * @return string
     */
    public function getRegionsSQLWhere(string $column, string $operand = "OR"): string
    {
        if (sizeof($this->region_ids)) {
            $return = array();
            array_walk($this->region_ids, function($value, $key) use (&$return) {
                $return[$key] = $this->dbh->quote($value);
            });

            return sprintf(" %s %s IN (%s)", $operand, $column, implode($return));
        }

        return "";
    }

    /**
     * Возвращает where для SQL
     * @param string $column
     * @param string $operand
     * @return string
     */
    public function getCitiesSQLWhere(string $column, string $operand = "AND"): string
    {
        if (sizeof($this->city_ids)) {
            $return = array();
            array_walk($this->city_ids, function($value, $key) use (&$return) {
                $return[$key] = $this->dbh->quote($value);
            });

            return sprintf(" %s %s IN (%s)", $operand, $column, implode($return));
        }

        return "";
    }
}