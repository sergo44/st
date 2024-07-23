<?php

namespace St;

enum CatalogObjectsStatusesEnum
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

    public function getActionLabel(): string
    {
        return match ($this) {
            self::Wait => "переведен в статус \"ожидает проверки\"",
            self::Approved => "одобрен",
            self::Decline => "запрещен к показу",
        };
    }
}
