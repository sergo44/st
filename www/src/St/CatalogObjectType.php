<?php

namespace St;

enum CatalogObjectType
{
    /**
     * Тип объекта "Отель"
     */
    case Hotel;
    /**
     * Тип объекта "Гостевой дом"
     */
    case Guest_House;
    /**
     * Тип объекта "Хостел"
     */
    case Hostel;
    /**
     * Квартира
     */
    case Apartment;
    /**
     * Тип объекта "Кемпинг"
     */
    case Camping;

    /**
     * Возвращает возможные варианты выбора
     * @return string[]
     */
    public static function getSelectOptions(): array
    {
        return array(
            self::Hotel->name => "Гостиница",
            self::Guest_House->name => "Гостевой дом",
            self::Hostel->name => "Хостел",
            self::Apartment->name => "Квартира",
            self::Camping->name => "Кемпинг",
        );
    }


}