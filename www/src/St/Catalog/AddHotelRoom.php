<?php

namespace St\Catalog;

use PDO;
use St\Db;
use St\HotelRoom;
use St\IWriteDb;

class AddHotelRoom implements IWriteDb
{
    /**
     * Добавление комнаты в базу данных
     * @var HotelRoom
     */
    protected HotelRoom $hotel_room;
    /**
     * Объект PDO
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор объекта
     * @param HotelRoom $hotel_room
     * @param PDO|null $dbh
     */
    public function __construct(HotelRoom $hotel_room, ?PDO $dbh = null)
    {
        $this->hotel_room = $hotel_room;
        $this->dbh = $dbh ?: Db::getWritePDOInstance();
    }

    /**
     * Добавление в базу данных
     * @return $this
     */
    public function add(): AddHotelRoom
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            INSERT INTO catalog_objects_hotel_rooms
            (
                object_id,
                image,
                name,
                description,
                price
            ) 
            VALUES 
            (
                :object_id,
                :image,
                :name,
                :description,
                :price
            )
        ");

        $sth->execute(array(
            ":object_id" => $this->hotel_room->getObjectId(),
            ":image" => $this->hotel_room->getImage(),
            ":name" => $this->hotel_room->getName(),
            ":description" => $this->hotel_room->getDescription(),
            ":price" => $this->hotel_room->getPrice()
        ));

        return $this;
    }
}