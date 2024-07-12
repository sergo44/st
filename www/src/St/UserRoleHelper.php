<?php
/**
 * Класс помощник по правам доступа
 */
namespace St;

class UserRoleHelper
{
    /**
     * Пользователь, для которого выполняется методы класса
     * @var User
     */
    protected User $user;

    /**
     * Конструктор объекта
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Пользователь может модерировать контент
     * @return bool
     */
    public function canModerationObjects(): bool
    {
        return
            $this->user->getUserRoleAsEnum()->name === UserRole::Administrator->name
            || $this->user->getUserRoleAsEnum()->name === UserRole::Editor->name
        ;
    }
}