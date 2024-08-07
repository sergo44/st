<?php

namespace St\Sights;

enum SightStatusEnum
{
    /**
     * Статус "Ожидает проверки"
     */
    case Wait;
    /**
     * Статус "Одобрено"
     */
    case Approved;
    /**
     * Статус отклонено
     */
    case Decline;

    public function label(): string
    {
        return match($this) {
            self::Wait => "Ожидает проверки",
            self::Approved => "Одобрено",
            self::Decline => "Отклонено"
        };
    }
}
