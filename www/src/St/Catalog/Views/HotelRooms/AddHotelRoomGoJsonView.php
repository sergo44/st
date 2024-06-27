<?php

namespace St\Catalog\Views\HotelRooms;

use St\HotelRoom;
use St\Views\IView;
use St\Views\JsonView;

class AddHotelRoomGoJsonView extends JsonView implements IView, \JsonSerializable
{
    /**
     * Комната, которую добавляем
     * @var HotelRoom
     */
    protected HotelRoom $hotel_room;

    /**
     * Возвращает hotel_room
     * @return HotelRoom
     * @see hotel_room
     */
    public function getHotelRoom(): HotelRoom
    {
        return $this->hotel_room;
    }

    /**
     * Устанавливает hotel_room
     * @param HotelRoom $hotel_room
     * @return AddHotelRoomGoJsonView
     * @see hotel_room
     */
    public function setHotelRoom(HotelRoom $hotel_room): AddHotelRoomGoJsonView
    {
        $this->hotel_room = $hotel_room;
        return $this;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult(),
            "hotel_room" => $this->getHotelRoom(),
            "list_hotel_html_element" => $this->getResult()->isSuccess() ?  (new ListHotelRoomsHtmlView($this->hotel_room))->fetch() : null
        );
    }
}