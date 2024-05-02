<?php

namespace St\User\Views\UserRegister;

use St\Result;
use St\User;

interface IUserRegisterGoView
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
     * @return IUserRegisterGoView
     * @see user
     */
    public function setUser(User $user): IUserRegisterGoView;
}