<?php

namespace St\User;

use PDO;
use St\Db;
use St\IReadDb;
use St\User;

class GetWaitConfirmationCodeUsers implements IReadDb
{
    /**
     * Выполнить блокировку строк
     * @var bool
     */
    protected bool $lock = false;
    /**
     * Объект для работы с базой данных
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param PDO|null $dbh
     */
    public function __construct(?PDO $dbh = null)
    {
        $this->dbh = $dbh ?? Db::getReadPDOInstance();
    }

    /**
     * Возвращает lock
     * @return bool
     * @see lock
     */
    public function isLock(): bool
    {
        return $this->lock;
    }

    /**
     * Устанавливает lock
     * @param bool $lock
     * @return GetWaitConfirmationCodeUsers
     * @see lock
     */
    public function setLock(bool $lock): GetWaitConfirmationCodeUsers
    {
        $this->lock = $lock;
        return $this;
    }

    /**
     * Возвращает пользователей
     * @return User[]
     */
    public function getUsers(): array
    {
        if (!$this->lock) {
            $sth = $this->dbh->query(/** @lang MariaDB */"SELECT * FROM users WHERE email_confirmation_code_sent = '0'");
        } else {
            $sth = $this->dbh->query(/** @lang MariaDB */"SELECT * FROM users WHERE email_confirmation_code_sent = '0' FOR UPDATE");
        }

        return $sth->fetchAll(PDO::FETCH_CLASS, User::class);
    }

}