<?php

namespace St\User;

use PDO;
use St\ApplicationError;
use St\Db;
use St\IReadDb;
use St\User;

class FindUserById implements IReadDb
{
    /**
     * Объект PDO для работы
     * @var PDO
     */
    protected PDO $dbh;
    /**
     * Пользователь, которого необходимо просмотреть
     * @var string
     */
    protected string $user_id;

    /**
     * Конструктор
     * @param int $user_id
     * @param PDO|null $dbh
     */
    public function __construct(int $user_id, ?PDO $dbh = null)
    {
        $this->user_id = $user_id;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает пользователя по имени пользователя
     * @throws ApplicationError
     */
    public function getUser(): ?User
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240412-1455 */ * FROM users where user_id = :user_id");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);

        $sth->execute(array(
            ":user_id" => $this->user_id
        ));

        if ($sth->rowCount() === 0) {
            return null;
        } elseif ($sth->rowCount() === 1) {
            return $sth->fetch();
        } else {
            throw new ApplicationError(sprintf("Multiple user selected from database use id %s", $this->user_id));
        }
    }
}