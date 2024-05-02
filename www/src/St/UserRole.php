<?php

namespace St;

enum UserRole
{
    /**
     * Обычный пользователь
     */
    case Guest;
    /**
     * Редактор каталога
     */
    case Editor;
    /**
     * Администратор проекта
     */
    case Administrator;
    /**
     * Владелец
     */
    case Owner;

}
