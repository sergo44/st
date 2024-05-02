<?php

namespace St\Utils;

class Validator
{
    /**
     * Проверяет адрес электронной почты на наличие ошибки
     * @param string $email
     * @return bool
     */
    public static function validate_email(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Проверяет логин на допустимые символы
     * @param string $login
     * @return bool
     */
    public static function validate_login(string $login): bool
    {
        return (bool)preg_match("/^[a-z]+[a-z0-9\-_]*$/ui", $login);
    }
}