<?php

namespace St\Catalog;

use St\HotelRoom;

class HotelRoomOrder
{
    protected int $hotel_room_id;
    /**
     * Имя, которое указал
     * @var string
     */
    protected string $name;
    /**
     * Адрес электронной почты
     * @var string
     */
    protected string $email;
    /**
     * Указанный номер телефона
     * @var string
     */
    protected string $phone;
    /**
     * Желаемая дата заезда
     * @var string
     */
    protected string $arrival_date;
    /**
     * Желаемая дата выезда
     * @var string
     */
    protected string $departure_date;
    /**
     * Дополнительная информация, замечания
     * @var string
     */
    protected string $remark;
    /**
     * Номер, который пользователь хотел забронировать
     * @var HotelRoom|null
     */
    protected ?HotelRoom $hotel_room = null;

    /**
     * Возвращает hotel_room_id
     * @return int
     * @see hotel_room_id
     */
    public function getHotelRoomId(): int
    {
        return $this->hotel_room_id;
    }

    /**
     * Устанавливает hotel_room_id
     * @param int $hotel_room_id
     * @return HotelRoomOrder
     * @see hotel_room_id
     */
    public function setHotelRoomId(int $hotel_room_id): HotelRoomOrder
    {
        $this->hotel_room_id = $hotel_room_id;
        return $this;
    }

    /**
     * Возвращает name
     * @return string
     * @see name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Устанавливает name
     * @param string $name
     * @return HotelRoomOrder
     * @see name
     */
    public function setName(string $name): HotelRoomOrder
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает email
     * @return string
     * @see email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Устанавливает email
     * @param string $email
     * @return HotelRoomOrder
     * @see email
     */
    public function setEmail(string $email): HotelRoomOrder
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Возвращает phone
     * @return string
     * @see phone
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Устанавливает phone
     * @param string $phone
     * @return HotelRoomOrder
     * @see phone
     */
    public function setPhone(string $phone): HotelRoomOrder
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Возвращает arrival_date
     * @return string
     * @see arrival_date
     */
    public function getArrivalDate(): string
    {
        return $this->arrival_date;
    }

    /**
     * Устанавливает arrival_date
     * @param string $arrival_date
     * @return HotelRoomOrder
     * @see arrival_date
     */
    public function setArrivalDate(string $arrival_date): HotelRoomOrder
    {
        $this->arrival_date = $arrival_date;
        return $this;
    }

    /**
     * Возвращает departure_date
     * @return string
     * @see departure_date
     */
    public function getDepartureDate(): string
    {
        return $this->departure_date;
    }

    /**
     * Устанавливает departure_date
     * @param string $departure_date
     * @return HotelRoomOrder
     * @see departure_date
     */
    public function setDepartureDate(string $departure_date): HotelRoomOrder
    {
        $this->departure_date = $departure_date;
        return $this;
    }

    /**
     * Возвращает remark
     * @return string
     * @see remark
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * Устанавливает remark
     * @param string $remark
     * @return HotelRoomOrder
     * @see remark
     */
    public function setRemark(string $remark): HotelRoomOrder
    {
        $this->remark = $remark;
        return $this;
    }

    public function getHotelRoom(): HotelRoom
    {
        if (!isset($this->hotel_room) && $this->hotel_room_id) {
            $this->hotel_room = HotelRoom::get($this->hotel_room_id);
        }

        return $this->hotel_room;
    }

}