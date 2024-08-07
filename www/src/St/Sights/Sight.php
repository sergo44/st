<?php

namespace St\Sights;

use St\Db;

class Sight
{
    /**
     * Идентификатор
     * @var int|null
     */
    protected ?int $sight_id;
    /**
     * Идентификатор пользователя
     * @var int
     */
    protected int $user_id;
    /**
     * Страна локации
     * @var int
     */
    protected int $country_id;
    /**
     * Идентификатор региона
     * @var int
     */
    protected int $region_id;
    /**
     * Идентификатор города
     * @var int
     */
    protected int $city_id;
    /**
     * Наименование
     * @var string
     */
    protected string $name;
    /**
     * Дата и время создания в UTC
     * @var string
     */
    protected string $created_datetime_utc;
    /**
     * Широта
     * @var float
     */
    protected float $lat;
    /**
     * Долгота
     * @var float
     */
    protected float $lon;
    /**
     * Описание
     * @var string
     */
    protected string $description;
    /**
     * Режим работы
     * @var string|null
     */
    protected ?string $operating_mode;
    /**
     * Стоимость посещения
     * @var string|null
     */
    protected ?string $price;
    /**
     * Контактный номер телефона
     * @var string|null
     */
    protected ?string $contact_phone;
    /**
     * Контактный адрес электронной почты
     * @var string|null
     */
    protected ?string $contact_email;
    /**
     * Адрес веб сайта
     * @var string|null
     */
    protected ?string $web_site_url;
    /**
     * Статус
     * @var string
     */
    protected string $status = SightStatusEnum::Wait->name;
    /**
     * Изображения объекта
     * @var SightImage[]
     */
    protected ?array $images = null;

    /**
     * Возвращает sight_id
     * @return int|null
     * @see sight_id
     */
    public function getSightId(): ?int
    {
        return $this->sight_id;
    }

    /**
     * Устанавливает sight_id
     * @param int|null $sight_id
     * @return Sight
     * @see sight_id
     */
    public function setSightId(?int $sight_id): Sight
    {
        $this->sight_id = $sight_id;
        return $this;
    }

    /**
     * Возвращает user_id
     * @return int
     * @see user_id
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Устанавливает user_id
     * @param int $user_id
     * @return Sight
     * @see user_id
     */
    public function setUserId(int $user_id): Sight
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * Возвращает country_id
     * @return int
     * @see country_id
     */
    public function getCountryId(): int
    {
        return $this->country_id;
    }

    /**
     * Устанавливает country_id
     * @param int $country_id
     * @return Sight
     * @see country_id
     */
    public function setCountryId(int $country_id): Sight
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * Возвращает region_id
     * @return int
     * @see region_id
     */
    public function getRegionId(): int
    {
        return $this->region_id;
    }

    /**
     * Устанавливает region_id
     * @param int $region_id
     * @return Sight
     * @see region_id
     */
    public function setRegionId(int $region_id): Sight
    {
        $this->region_id = $region_id;
        return $this;
    }

    /**
     * Возвращает city_id
     * @return int
     * @see city_id
     */
    public function getCityId(): int
    {
        return $this->city_id;
    }

    /**
     * Устанавливает city_id
     * @param int $city_id
     * @return Sight
     * @see city_id
     */
    public function setCityId(int $city_id): Sight
    {
        $this->city_id = $city_id;
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
     * @return Sight
     * @see name
     */
    public function setName(string $name): Sight
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает created_datetime_utc
     * @return string
     * @see created_datetime_utc
     */
    public function getCreatedDatetimeUtc(): string
    {
        return $this->created_datetime_utc;
    }

    /**
     * Устанавливает created_datetime_utc
     * @param string $created_datetime_utc
     * @return Sight
     * @see created_datetime_utc
     */
    public function setCreatedDatetimeUtc(string $created_datetime_utc): Sight
    {
        $this->created_datetime_utc = $created_datetime_utc;
        return $this;
    }

    /**
     * Возвращает lat
     * @return float
     * @see lat
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * Устанавливает lat
     * @param float $lat
     * @return Sight
     * @see lat
     */
    public function setLat(float $lat): Sight
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Возвращает lon
     * @return float
     * @see lon
     */
    public function getLon(): float
    {
        return $this->lon;
    }

    /**
     * Устанавливает lon
     * @param float $lon
     * @return Sight
     * @see lon
     */
    public function setLon(float $lon): Sight
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * Возвращает description
     * @return string
     * @see description
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Устанавливает description
     * @param string $description
     * @return Sight
     * @see description
     */
    public function setDescription(string $description): Sight
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Возвращает operating_mode
     * @return string|null
     * @see operating_mode
     */
    public function getOperatingMode(): ?string
    {
        return $this->operating_mode;
    }

    /**
     * Устанавливает operating_mode
     * @param string|null $operating_mode
     * @return Sight
     * @see operating_mode
     */
    public function setOperatingMode(?string $operating_mode): Sight
    {
        $this->operating_mode = $operating_mode;
        return $this;
    }

    /**
     * Возвращает price
     * @return string|null
     * @see price
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * Устанавливает price
     * @param string|null $price
     * @return Sight
     * @see price
     */
    public function setPrice(?string $price): Sight
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Возвращает contact_phone
     * @return string|null
     * @see contact_phone
     */
    public function getContactPhone(): ?string
    {
        return $this->contact_phone;
    }

    /**
     * Устанавливает contact_phone
     * @param string|null $contact_phone
     * @return Sight
     * @see contact_phone
     */
    public function setContactPhone(?string $contact_phone): Sight
    {
        $this->contact_phone = $contact_phone;
        return $this;
    }

    /**
     * Возвращает contact_email
     * @return string|null
     * @see contact_email
     */
    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    /**
     * Устанавливает contact_email
     * @param string|null $contact_email
     * @return Sight
     * @see contact_email
     */
    public function setContactEmail(?string $contact_email): Sight
    {
        $this->contact_email = $contact_email;
        return $this;
    }

    /**
     * Возвращает web_site_url
     * @return string|null
     * @see web_site_url
     */
    public function getWebSiteUrl(): ?string
    {
        return $this->web_site_url;
    }

    /**
     * Устанавливает web_site_url
     * @param string|null $web_site_url
     * @return Sight
     * @see web_site_url
     */
    public function setWebSiteUrl(?string $web_site_url): Sight
    {
        $this->web_site_url = $web_site_url;
        return $this;
    }

    /**
     * Возвращает status
     * @return string
     * @see status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Устанавливает status
     * @param string $status
     * @return Sight
     * @see status
     */
    public function setStatus(string $status): Sight
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Возвращает статус в виде enum объекта
     * @return SightStatusEnum
     */
    public function getStatusEnum(): SightStatusEnum
    {
        return SightStatusEnum::{$this->status};
    }

    /**
     * Возвращает изображения
     * @return SightImage[]
     */
    public function getImages(): array
    {
        if (!isset($this->images)) {
            $this->images = (new GetSightImages($this))->getImages();
        }

        return $this->images;
    }

    /**
     * Возвращает основное изображение
     * @return SightImage|null
     */
    public function getMainImage(): SightImage|null
    {
        return $this->getImages()[0] ?? null;
    }
}