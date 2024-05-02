<?php

namespace St;

class Auth
{
    /**
     * Текущий экземпляр класса
     * @var Auth|null
     */
    protected static ?Auth $instance = null;
    /**
     * Текущий авторизованный пользователь
     * @var User|null
     */
    protected ?User $user = null;

    /**
     * Возвращает единственный экземпляр класса
     * @return Auth
     * @throws ApplicationError
     */
    public static function getInstance(): Auth
    {
        if (!isset(self::$instance)) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                if (headers_sent()) {
                    throw new ApplicationError("Session start failed. Headers has been sent");
                }
            }
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Конструктор класса
     */
    protected function __construct()
    {

    }

    /**
     * Возвращает авторизованного пользователя (из сессии)
     * @return User|null
     * @throws ApplicationError
     */
    public function get(): ?User
    {
        if (!isset($this->user) && isset($_SESSION['user_id']) && $_SESSION['user_id']) {
            $this->user = User::get($_SESSION['user_id']);
        }

        return $this->user;
    }

    /**
     * Устанавливает авторизацию
     * @param User $user
     * @return void
     */
    public function set(User $user): void
    {
        $this->user = $user;
        $_SESSION['user_id'] = $user->getUserId();
    }
}