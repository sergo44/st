<?php

namespace St;

use Redis as Redis;
use RedisException;

class RedisHelper
{
    /**
     * Инстанс объекта Redis Helper
     * @var RedisHelper|null
     */
    protected static ?RedisHelper $default_instance = null;
    /**
     * Объект Redis
     * @var Redis
     */
    protected Redis $redis;
    /**
     * Хост для подключения
     * @var string
     */
    protected string $host = ST_DEFAULT_REDIS_HOST;
    /**
     * Порт для подключения
     * @var int
     */
    protected int $port = ST_DEFAULT_REDIS_PORT;
    /**
     * Таймаут подключения
     * @var float
     */
    protected float $timeout = ST_DEFAULT_REDIS_TIMEOUT;

    /**
     * Возвращает instance объекта
     * @return self
     */
    public static function getInstance(): self
    {
        if (!isset(self::$default_instance)) {
            $self = self::$default_instance = new self();
        }

        return self::$default_instance;
    }

    /**
     * Отключаем возможность создания объекта в иных классах
     * @throws RedisException
     */
    protected function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect($this->host, $this->port, $this->timeout);
        $this->redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_JSON);
    }

    /**
     * Отключаемся при уничтожении объекта
     * @throws RedisException
     */
    public function __destruct()
    {
        $this->redis->close();
    }

    /**
     * Устанавливаем значение
     * @param string $key
     * @param $value
     * @param int $ttl
     * @return $this
     * @throws RedisException
     */
    public function setValue(string $key, $value, int $ttl = 3600): self
    {
        $this->redis->set($key, $value, $ttl);
        return $this;
    }

    /**
     * Получаем значение
     * @throws RedisException
     */
    public function getValue(string $key)
    {
        return $this->redis->get($key);
    }
}