<?php

namespace St\User;

use PDO;
use St\IReadDb;
use St\User;

class GetAllUsers implements IReadDb
{
    /**
     * Объект PDO
     * @var PDO
     */
    protected PDO $dbh;
    /**
     * Конструктор класса
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh;
    }

    /**
     * Возвращает пользователей
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->dbh
            ->query(/** @lang MariaDB */"SELECT * FROM users ORDER BY registered_datetime_utc")
            ->fetchAll(PDO::FETCH_CLASS, User::class);
    }
}