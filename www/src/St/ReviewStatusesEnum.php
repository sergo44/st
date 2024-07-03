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
}
