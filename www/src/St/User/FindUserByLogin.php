<?php

namespace St\User;

use St\ApplicationError;
use St\Db;
use St\IReadDb;
use St\User;

class FindUserByLogin implements IReadDb
{
    /**
     * Объект PDO для работы
     * @var \PDO
     */
    protected \PDO $dbh;
    /**
     * Пользователь, которого необходимо просмотреть
     * @var string
     */
    protected string $login;

    /**
     * Конструктор
     * @param string $login
     * @param \PDO|null $dbh
     */
    public function __construct(string $login, ?\PDO $dbh = null)
    {
        $this->login = $login;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает пользователя по имени пользователя
     * @throws ApplicationError
     */
    public function getUser(): ?User
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240410-1232 */ * FROM users where login = :login");
        $sth->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, User::class);

        $sth->execute(array(
            ":login" => $this->login
        ));

        if ($sth->rowCount() === 0) {
            return null;
        } elseif ($sth->rowCount() === 1) {
            return $sth->fetch();
        } else {
            throw new ApplicationError(sprintf("Multiple user selected from database use login %s", $this->login));
        }
    }
}