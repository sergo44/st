<?php

namespace St;

use DateTime;
use Exception;
use PDO;
use St\Reviews\GetAllObjectReviews;

class CatalogObject implements IReadDb
{
    /**
     * Изображения, привязанные к объекту
     * @var array|null
     */
    protected ?array $images;
    /**
     * Идентификатор объекта
     * @var int|null
     */
    protected ?int $object_id = null;
    /**
     * Тип Объекта
     * @var string
     */
    protected string $object_type = CatalogObjectType::Hostel->name;
    /**
     * Идентификатор пользователя, который добавил объект
     * @var int
     */
    protected int $user_id = 0;
    /**
     * Дата и время публикации (UTC)
     * @var string|null
     */
    protected ?string $posted_datetime = null;
    /**
     * Дата и время последнего редактирования. В случае создания объекта указывать дату и время создания
     * @var string|null
     */
    protected ?string $last_modified_datetime = null;
    /**
     * Наименование объекта
     * @var string
     */
    protected string $name = "";
    /**
     * Идентификатор страны, к которой принадлежит объект
     * @var int
     */
    protected int $country_id = 0;
    /**
     * Идентификатор региона, к которому принадлежит объект
     * @var int
     */
    protected int $region_id = 0;
    /**
     * Идентификатор города, к которой принадлежит объект
     * @var int
     */
    protected int $city_id = 0;
    /**
     * Строка адресе
     * @var string
     */
    protected string $address_lines = "";
    /**
     * Описание объекта
     * @var string
     */
    protected string $description = "";
    /**
     * Широта объекта на географической карте
     * @var float|null
     */
    protected ?float $lat = 0.0;
    /**
     * Долгота объекта на географической карте
     * @var float|null
     */
    protected ?float $lon = 0.0;
    /**
     * Информация о включении питания
     * @var string
     */
    protected string $include_foods = "";
    /**
     * Цена размещения (от)
     * @var int
     */
    protected int $start_price = 0;
    /**
     * Контактный номер телефона
     * @var string
     */
    protected string $contact_phone = "";
    /**
     * Контактный адрес электронной почты
     * @var string
     */
    protected string $contact_email = "";
    /**
     * Адрес веб сайта
     * @var string|null
     */
    protected ?string $web_site_url = "";
    /**
     * Номера
     * @var HotelRoom[]|null
     */
    protected ?array $hotel_rooms = null;
    /**
     * Все отзывы объекта
     * @var Review[]|null
     */
    protected ?array $all_reviews = null;
    /**
     * Статус объекта
     * @see CatalogObjectsStatusesEnum
     * @var string
     */
    protected string $status = "Wait";
    /**
     * Идентификатор пользователя, который последним принимал решение о публикации объекта
     * @var string|null
     */
    protected ?string $processed_user_id = null;

    /**
     * Возвращает объект по идентификатору
     * @param int $object_id
     * @param PDO|null $dbh
     * @return CatalogObject
     */
    public static function get(int $object_id, ?PDO $dbh = null): CatalogObject
    {
        $dbh = $dbh ?? Db::getReadPDOInstance();

        $sth = $dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects WHERE object_id = :object_id");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, CatalogObject::class);
        $sth->execute(array(
            ":object_id" => $object_id
        ));

        return $sth->rowCount() ? $sth->fetch() : new CatalogObject();
    }

    /**
     * Возвращает object_id
     * @return int|null
     * @see object_id
     */
    public function getObjectId(): ?int
    {
        return $this->object_id;
    }

    /**
     * Устанавливает object_id
     * @param int|null $object_id
     * @return CatalogObject
     * @see object_id
     */
    public function setObjectId(?int $object_id): CatalogObject
    {
        $this->object_id = $object_id;
        return $this;
    }

    /**
     * Возвращает object_type
     * @return string
     * @see object_type
     */
    public function getObjectType(): string
    {
        return $this->object_type;
    }

    /**
     * Устанавливает object_type
     * @param string $object_type
     * @return CatalogObject
     * @see object_type
     */
    public function setObjectType(string $object_type): CatalogObject
    {
        $this->object_type = $object_type;
        return $this;
    }

    /**
     * Возвращает тип объект в виде перечисляемого типа
     * @return CatalogObjectType
     */
    public function getObjectAsEnum(): CatalogObjectType
    {
        return CatalogObjectType::{$this->object_type};
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
     * @return CatalogObject
     * @see user_id
     */
    public function setUserId(int $user_id): CatalogObject
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * Возвращает posted_datetime
     * @return string|null
     * @see posted_datetime
     */
    public function getPostedDatetime(): ?string
    {
        return $this->posted_datetime;
    }

    /**
     * Устанавливает posted_datetime
     * @param string|null $posted_datetime
     * @return CatalogObject
     * @see posted_datetime
     */
    public function setPostedDatetime(?string $posted_datetime): CatalogObject
    {
        $this->posted_datetime = $posted_datetime;
        return $this;
    }

    /**
     * Возвращает last_modified_datetime
     * @return string|null
     * @see last_modified_datetime
     */
    public function getLastModifiedDatetime(): ?string
    {
        return $this->last_modified_datetime;
    }

    /**
     * Устанавливает last_modified_datetime
     * @param string|null $last_modified_datetime
     * @return CatalogObject
     * @see last_modified_datetime
     */
    public function setLastModifiedDatetime(?string $last_modified_datetime): CatalogObject
    {
        $this->last_modified_datetime = $last_modified_datetime;
        return $this;
    }

    /**
     * Возвращает дату последнего редактирования (создания) объекта в виде Datetime объекта
     * @return DateTime
     */
    public function getLastModifiedDatetimeAsObject(): DateTime
    {
        try {
            return new DateTime($this->getLastModifiedDatetime());
        } catch (Exception $e) {
            return new DateTime("@0");
        }
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
     * @return CatalogObject
     * @see name
     */
    public function setName(string $name): CatalogObject
    {
        $this->name = $name;
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
     * @return CatalogObject
     * @see country_id
     */
    public function setCountryId(int $country_id): CatalogObject
    {
        $this->country_id = $country_id;
        return $this;
    }

    /**
     * Возвращает страну, к которой отнесен объект. Если страна не найдена, то будет возвращен
     * новый пустой объект. Если идентификтаор страны неуказан для объекта, будет возвращен null
     * @return Country|null
     * @throws ApplicationError
     */
    public function getCountry(): ?Country
    {
        return $this->getCountryId() ? Country::get($this->getCountryId()) : null;
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
     * @return CatalogObject
     * @see region_id
     */
    public function setRegionId(int $region_id): CatalogObject
    {
        $this->region_id = $region_id;
        return $this;
    }

    /**
     * Возвращает регион
     * @return Region|null Если для объекта указан регион, то будет возвращен регион.
     * Если он не будет найден по какой-то причине, будет возвращен новый объект типа Region.
     * В случае если region_id не указан для объекта, будет возвращен NULL
     * @throws ApplicationError
     */
    public function getRegion(): ?Region
    {
        if ($this->getRegionId()) {
            return Region::get($this->getRegionId());
        }

        return null;
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
     * @return CatalogObject
     * @see city_id
     */
    public function setCityId(int $city_id): CatalogObject
    {
        $this->city_id = $city_id;
        return $this;
    }

    /**
     * Возвращает город, указанный для объекта
     * @return City|null Возвращает null, если для объекта не указан $city_id, кроме того,
     * если город не существует с указанным, будет возвращен новый объект типа City
     * @throws ApplicationError
     */
    public function getCity(): ?City
    {
        if ($this->getCityId()) {
            return City::get($this->getCityId());
        }

        return null;
    }

    /**
     * Возвращает address_lines
     * @return string
     * @see address_lines
     */
    public function getAddressLines(): string
    {
        return $this->address_lines;
    }

    /**
     * Устанавливает address_lines
     * @param string $address_lines
     * @return CatalogObject
     * @see address_lines
     */
    public function setAddressLines(string $address_lines): CatalogObject
    {
        $this->address_lines = $address_lines;
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
     * @return CatalogObject
     * @see description
     */
    public function setDescription(string $description): CatalogObject
    {
        $this->description = $description;
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
     * @return CatalogObject
     * @see lat
     */
    public function setLat(float $lat): CatalogObject
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
     * @return CatalogObject
     * @see lon
     */
    public function setLon(float $lon): CatalogObject
    {
        $this->lon = $lon;
        return $this;
    }

    /**
     * Возвращает include_foods
     * @return string
     * @see include_foods
     */
    public function getIncludeFoods(): string
    {
        return $this->include_foods;
    }

    /**
     * Устанавливает include_foods
     * @param string $include_foods
     * @return CatalogObject
     * @see include_foods
     */
    public function setIncludeFoods(string $include_foods): CatalogObject
    {
        $this->include_foods = $include_foods;
        return $this;
    }

    /**
     * Возвращает start_price
     * @return int
     * @see start_price
     */
    public function getStartPrice(): int
    {
        return $this->start_price;
    }

    /**
     * Устанавливает start_price
     * @param int $start_price
     * @return CatalogObject
     * @see start_price
     */
    public function setStartPrice(int $start_price): CatalogObject
    {
        $this->start_price = $start_price;
        return $this;
    }

    /**
     * Возвращает contact_phone
     * @return string
     * @see contact_phone
     */
    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    /**
     * Устанавливает contact_phone
     * @param string $contact_phone
     * @return CatalogObject
     * @see contact_phone
     */
    public function setContactPhone(string $contact_phone): CatalogObject
    {
        $this->contact_phone = $contact_phone;
        return $this;
    }

    /**
     * Возвращает contact_email
     * @return string
     * @see contact_email
     */
    public function getContactEmail(): string
    {
        return $this->contact_email;
    }

    /**
     * Устанавливает contact_email
     * @param string $contact_email
     * @return CatalogObject
     * @see contact_email
     */
    public function setContactEmail(string $contact_email): CatalogObject
    {
        $this->contact_email = $contact_email;
        return $this;
    }

    /**
     * Возвращает web_site_url
     * @return string
     * @see web_site_url
     */
    public function getWebSiteUrl(): string
    {
        return $this->web_site_url;
    }

    /**
     * Устанавливает web_site_url
     * @param string $web_site_url
     * @return CatalogObject
     * @see web_site_url
     */
    public function setWebSiteUrl(string $web_site_url): CatalogObject
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
     * @return CatalogObject
     * @see status
     */
    public function setStatus(string $status): CatalogObject
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Возвращает processed_user_id
     * @return string|null
     * @see processed_user_id
     */
    public function getProcessedUserId(): ?string
    {
        return $this->processed_user_id;
    }

    /**
     * Устанавливает processed_user_id
     * @param string|null $processed_user_id
     * @return CatalogObject
     * @see processed_user_id
     */
    public function setProcessedUserId(?string $processed_user_id): CatalogObject
    {
        $this->processed_user_id = $processed_user_id;
        return $this;
    }

    /**
     * Возвращает изображения объекта
     * @return Image[]
     */
    public function getImages(): array
    {
        if (!isset($this->images)) {
            $dbh = Db::getReadPDOInstance();
            $sth = $dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects_images WHERE object_id = :object_id ORDER BY image_id");
            $sth->execute(array(
                ":object_id" => $this->getObjectId()
            ));

            $this->images = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_CLASS, Image::class);
        }

        return $this->images;
    }

    /**
     * Возвращает первое изображение. Если изображение нет, возвращает NULL
     * @return Image|null
     */
    public function getFirstImage(): ?Image
    {
        return $this->getImages()[0] ?? null;
    }

    /**
     * Возвращает дополнительные изображения для отображения
     * @param int $limit
     * @return Image[]
     */
    public function getAdditionalImages(int $limit = 4): array
    {
        $images = $this->getImages();
        return sizeof($images) > 1 ? array_slice($images, 1, $limit) : array();
    }

    /**
     * Возвращает номера
     * @return HotelRoom[]
     */
    public function getHotelRooms(): array
    {
        if (!isset($this->hotel_rooms)) {
            $sth = Db::getReadPDOInstance()->prepare(/** @lang MariaDB */"SELECT /* 2024-06-07 10:58 */ * FROM catalog_objects_hotel_rooms where object_id = :object_id");
            $sth->execute(array(
                ":object_id" => $this->getObjectId()
            ));

            $this->hotel_rooms = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, HotelRoom::class);

        }

        return $this->hotel_rooms;
    }

    /**
     * Возвращает все отзывы объекта
     * @return Review[]
     */
    public function getAllReviews(): array
    {
        if (!isset($this->all_reviews) && $this->object_id) {
            $this->all_reviews = (new GetAllObjectReviews($this->object_id))->getReviews();
        }

        return $this->all_reviews ?: array();
    }

}