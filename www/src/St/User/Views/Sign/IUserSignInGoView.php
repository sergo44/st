<?php

namespace St\User\Views\Sign;

use St\Result;
use St\User;

interface IUserSignInGoView
{
    /**
     * Возвращает результат
     * @return Result
     */
    public function getResult(): Result;
    /**
     * Возвращает user
     * @return ?User
     * @see user
     */
    public function getUser(): ?User;

    /**
     * Устанавливает user
     * @param User $user
     * @see user
     */
    public function setUser(User $user);
}