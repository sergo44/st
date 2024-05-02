<?php

namespace St\User;

use St\ApplicationError;
use St\Db;
use St\Result;
use St\User;
use St\Utils\Validator;

class Register
{
    /**
     * Пользователь, которого необходимо зарегистрировать
     * @var User
     */
    protected User $user;
    /**
     * Подтверждение пароля
     * @var string
     */
    protected string $password_confirm;

    /**
     * Конструктор объекта
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Устанавливает password_confirm
     * @param string $password_confirm
     * @return Register
     * @see password_confirm
     */
    public function setPasswordConfirm(string $password_confirm): Register
    {
        $this->password_confirm = $password_confirm;
        return $this;
    }

    /**
     * @throws ApplicationError
     */
    public function check(?Result $result = null): Result
    {
        if (!isset($result)) {
            $result = new Result();
        }

        if (!$this->user->getName()) {
            $result->addError("Вы не указали Ваше имя", "name");
        }

        if (!$this->user->getLogin()) {
            $result->addError("Вы не указали логин для входа", "login");
        } else {
            $user = new FindUserByLogin($this->user->getLogin());
            if ($user->getUser()) {
                $result->addError("Пользователь с указанным Вами логином уже существует", "login");
            }
        }

        if (!Validator::validate_login($this->user->getLogin())) {
            $result->addError("Логин указан неверно, он может содержать только латинские символы, цифры и символы \"_\", \"-\"", "login");
        }

        if (!$this->user->getEmail()) {
            $result->addError("Вы не указали адрес электронной почты", "email");
        } else {
            $user = new FindUserByEmail($this->user->getEmail());
            if ($user->getUser()) {
                $result->addError("Пользователь с указанным Вами адресом электронной почты уже существует", "email");
            }
        }

        if (!Validator::validate_email($this->user->getEmail())) {
            $result->addError("Адрес электронной почты указан с ошибкой", "email");
        }

        if (!$this->user->getPassword()) {
            $result->addError("Пароль не указан", "password");
        }

        if ($this->user->getPassword() !== $this->password_confirm) {
            $result->addError("Пароль и его подтверждение не совпадают", "password");
        }

        return $result;
    }

    /**
     * Добавление пользователя в базу данных
     * @throws ApplicationError
     */
    public function addToDb(\PDO $dbh = null): void
    {
        if (!isset($dbh)) {
            $dbh = Db::getWritePDOInstance();
        }

        try {

            $dbh->beginTransaction();

            $sth = $dbh->prepare(/** @lang MariaDB */"
                /** @SQL 2024-02-01-001 */
                insert into `users`
                (name, login, timezone, email, phone, password_hash, user_role) 
                values 
                (:name, :login, :timezone, :email, :phone, :password_hash, :user_role)
            ");

            $sth->execute(array(
                ":name" => $this->user->getName(),
                ":login" => $this->user->getLogin(),
                ":timezone" => $this->user->getTimezone(),
                ":email" => $this->user->getEmail(),
                ":phone" => $this->user->getPhone(),
                ":password_hash" => $this->user->getPasswordHash(),
                ":user_role" => $this->user->getUserRole()
            ));

            $this->user->setUserId((int)$dbh->lastInsertId());

            $dbh->commit();


        } catch (\Exception $e) {
            if ($dbh->inTransaction()) {
                $dbh->rollBack();
            }

            throw new ApplicationError(sprintf("Error while adding user %s", $e->getMessage()));
        }
    }
}