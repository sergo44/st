<?php

namespace St\Catalog;

use PDO;
use St\Db;
use St\Fs;
use St\HotelRoom;
use St\IWriteDb;
use St\Result;

class RemoveHotelRoom implements IWriteDb
{
    /**
     * Номер, который необходимо удалить
     * @var HotelRoom
     */
    protected HotelRoom $hotel_room;
    /**
     * Объект PDO который необходимо удалить
     * @var PDO|null
     */
    protected ?PDO $dbh;

    /**
     * @param HotelRoom $hotel_room
     * @param PDO|null $dbh
     */
    public function __construct(HotelRoom $hotel_room, ?PDO $dbh = null)
    {
        $this->hotel_room = $hotel_room;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Удаляет номер из базы данных
     * @param Result $result
     * @return Result
     */
    public function remove(Result $result): Result
    {

        if ($this->hotel_room->getImage()) {
            Fs::purge_thumbs(dirname($this->hotel_room->getImage()), basename($this->hotel_room->getImage()));
        }

        $sth = $this->dbh->prepare(/** @lang MariaDB */"DELETE FROM catalog_objects_hotel_rooms where hotel_room_id = :hotel_room_id");
        $sth->execute(array(
            ":hotel_room_id" => $this->hotel_room->getHotelRoomId()
        ));

        return $result;
    }
}