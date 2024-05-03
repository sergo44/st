<?php

namespace St\Db;

class ProfileRow
{
    /**
     * Идентификатор запроса
     * @var int
     */
    protected int $Query_ID;
    /**
     * Время выполнения запроса
     * @var float
     */
    protected float $Duration;
    /**
     * Запрос, который был выполнен
     * @var string
     */
    protected string $Query;

    /**
     * Возвращает Query_ID
     * @return int
     * @see Query_ID
     */
    public function getQueryID(): int
    {
        return $this->Query_ID;
    }

    /**
     * Возвращает Duration
     * @return float
     * @see Duration
     */
    public function getDuration(): float
    {
        return $this->Duration;
    }

    /**
     * Возвращает Query
     * @return string
     * @see Query
     */
    public function getQuery(): string
    {
        return $this->Query;
    }

}