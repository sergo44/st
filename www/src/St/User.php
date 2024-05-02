<?php

namespace St;

use St\User\FindUserById;

class User implements \JsonSerializable, IUseRedis
{
    /**
     * Идентификатор пользователя
     * @var int|null
     */
    protected ?int $user_id = null;
    /**
     * Отображаемое имя пользователя
     * @var string
     */
    protected string $name = "";
    /**
     * Логин пользователя
     * @var string
     */
    protected string $login = "";
    /**
     * Часовая зона пользователя
     * @var string
     */
    protected string $timezone = "";
    /**
     * Адрес электронной почты пользователя
     * @var string
     */
    protected string $email = "";
    /**
     * Номер телефона пользователя
     * @var string
     */
    protected string $phone = "";
    /**
     * Пароль пользователя
     * @var string
     */
    protected string $password = "";
    /**
     * Хеш пароля
     * @var string
     */
    protected string $password_hash = "";
    /**
     * Роль пользователя
     * @var string
     */
    protected string $user_role = UserRole::Guest->name;

    /**
     * Sleep magic method
     * @return string[]
     */
    public function __sleep(): array
    {
        return array(
            "user_id",
            "name",
            "login",
            "timezone",
            "email",
            "phone",
            "user_role"
        );
    }

    /**
     * Получаем пользователя по идентификатору.
     * Если пользователь не найден, возвращается новый объект
     *
     * @todo Move To Redis Helper
     * @param int $user_id
     * @param bool $pop_cache
     * @param bool $push_cache
     * @return User
     * @throws ApplicationError
     */
    public static function get(int $user_id, bool $pop_cache = true, bool $push_cache = true): User
    {
        if ($pop_cache) {
            try {
                $cached_user = RedisHelper::getInstance()->getValue("user:{$user_id}");
                if ($cached_user) {
                    return unserialize($cached_user);
                }
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        $users = new FindUserById($user_id);
        $user = $users->getUser();

        if (!$user) {
            $user = new User();
        }

        if ($push_cache) {
            try {
                RedisHelper::getInstance()->setValue("user:{$user_id}", serialize($user));
            } catch (\RedisException $e) {
                if (ST_DEVELOPMENT_VERSION) {
                    throw new ApplicationError(sprintf("Redis failed: %s", $e->getMessage()));
                }
            }
        }

        return $user;
    }

    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "user_id" => $this->getUserId(),
            "name" => $this->getName(),
            "login" => $this->getLogin(),
            "timezone" => $this->getTimezone(),
            "email" => $this->getEmail(),
            "phone" => $this->getPhone(),
            "user_role" => $this->getUserRole()
        );
    }

    /**
     * Возвращает user_id
     * @return int|null
     * @see user_id
     */
    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    /**
     * Устанавливает user_id
     * @param int|null $user_id
     * @return User
     * @see user_id
     */
    public function setUserId(?int $user_id): User
    {
        $this->user_id = $user_id;
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
     * @return User
     * @see name
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает login
     * @return string
     * @see login
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Устанавливает login
     * @param string $login
     * @return User
     * @see login
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;
        return $this;
    }

    /**
     * Возвращает timezone
     * @return string
     * @see timezone
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * Устанавливает timezone
     * @param string $timezone
     * @return User
     * @see timezone
     */
    public function setTimezone(string $timezone): User
    {
        $this->timezone = $timezone;
        return $this;
    }

    /**
     * Возвращает email
     * @return string
     * @see email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Устанавливает email
     * @param string $email
     * @return User
     * @see email
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Возвращает phone
     * @return string
     * @see phone
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Устанавливает phone
     * @param string $phone
     * @return User
     * @see phone
     */
    public function setPhone(string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Возвращает password
     * @return string
     * @see password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Устанавливает password
     * @param string $password
     * @return User
     * @see password
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Возвращает password_hash
     * @return string
     * @see password_hash
     */
    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    /**
     * Устанавливает password_hash
     * @param string $password_hash
     * @return User
     * @see password_hash
     */
    public function setPasswordHash(string $password_hash): User
    {
        $this->password_hash = $password_hash;
        return $this;
    }

    /**
     * Возвращает user_role
     * @return string
     * @see user_role
     */
    public function getUserRole(): string
    {
        return $this->user_role;
    }

    /**
     * Устанавливает user_role
     * @param string $user_role
     * @return User
     * @throws ApplicationError
     * @see user_role
     */
    public function setUserRole(string $user_role): User
    {
        if (!defined(UserRole::class . "::" . $user_role)) {
            throw new ApplicationError("Unknown role {$user_role}");
        }

        $this->user_role = $user_role;
        return $this;
    }

    /**
     * Возвращает UserRole Enum объект
     * @return UserRole
     */
    public function getUserRoleAsEnum(): UserRole
    {
        return UserRole::{$this->user_role};
    }

}