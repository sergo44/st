<?php

namespace St;

enum ReviewStatusesEnum
{
    /**
     * Статус - ожидает обработки
     */
    case Wait;
    /**
     * Статус - одобрен к публикации
     */
    case Approved;
    /**
     * Статус - отклонен к публикации
     */
    case Decline;

    /**
     * Возвращает статус объекта
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::Wait => "Ожидает проверки",
            self::Approved => "Одобрен",
            self::Decline => "Отклонен"
        };
    }
}
