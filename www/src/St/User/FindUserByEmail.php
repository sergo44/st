<?php

namespace St\User;

use PDO;
use St\ApplicationError;
use St\Db;
use St\IReadDb;
use St\User;

class FindUserByEmail implements IReadDb
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
    protected string $email;

    /**
     * Конструктор
     * @param string $email
     * @param PDO|null $dbh
     */
    public function __construct(string $email, ?PDO $dbh = null)
    {
        $this->email = $email;
        $this->dbh = $dbh ?: Db::getReadPDOInstance();
    }

    /**
     * Возвращает пользователя по имени пользователя
     * @throws ApplicationError
     */
    public function getUser(): ?User
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"SELECT /* SQL 20240410-1257 */ * FROM users where email = :email");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, User::class);

        $sth->execute(array(
            ":email" => $this->email
        ));

        if ($sth->rowCount() === 0) {
            return null;
        } elseif ($sth->rowCount() === 1) {
            return $sth->fetch();
        } else {
            throw new ApplicationError(sprintf("Multiple user selected from database use email %s", $this->email));
        }
    }
}