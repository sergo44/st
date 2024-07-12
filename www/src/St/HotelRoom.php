<?php

namespace St;

use PDO;

class HotelRoom implements \JsonSerializable
{
    /**
     * Идентификатор комнаты (номера)
     * @var int|null
     */
    protected ?int $hotel_room_id = null;
    /**
     * Идентификатор объекта
     * @var int|null
     */
    protected ?int $object_id = null;
    /**
     * Фотография номера
     * @var string
     */
    protected string $image = "";
    /**
     * Наименование номера
     * @var string
     */
    protected string $name = "";
    /**
     * Описание комнаты (номера)
     * @var string
     */
    protected string $description = "";
    /**
     * Цена объекта
     * @var float
     */
    protected float $price = 0;
    /**
     * Временно загруженное изображение
     * @var string
     */
    protected string $uploaded_file = "";
    /**
     * Объект каталога, к которому привязан номер
     * @var CatalogObject|null
     */
    protected ?CatalogObject $catalog_object = null;

    /**
     * Создаем объект номера по переданному идентификатору. Если в БД не найден
     * указанный объект, будет возвращен пустой объект
     * @param int $hotel_room_id
     * @param PDO|null $dbh
     * @return HotelRoom
     */
    public static function get(int $hotel_room_id, ?PDO $dbh = null): HotelRoom
    {
        $dbh = $dbh ?: Db::getReadPDOInstance();
        $sth = $dbh->prepare(/** @lang MariaDB */"SELECT * FROM catalog_objects_hotel_rooms WHERE hotel_room_id = :hotel_room_id");
        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, HotelRoom::class);
        $sth->execute(array(
            ":hotel_room_id" => $hotel_room_id
        ));

        return $sth->rowCount() ? $sth->fetch() : new HotelRoom();
    }

    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "hotel_room_id" => $this->getHotelRoomId(),
            "object_id" => $this->getObjectId(),
            "image" => $this->getImage(),
            "name" => $this->getName(),
            "description" => $this->getDescription(),
            "price" => $this->getPrice(),
            "uploaded_file" => $this->getUploadedFile()
        );
    }

    /**
     * Возвращает hotel_room_id
     * @return int|null
     * @see hotel_room_id
     */
    public function getHotelRoomId(): ?int
    {
        return $this->hotel_room_id;
    }

    /**
     * Устанавливает hotel_room_id
     * @param int|null $hotel_room_id
     * @return HotelRoom
     * @see hotel_room_id
     */
    public function setHotelRoomId(?int $hotel_room_id): HotelRoom
    {
        $this->hotel_room_id = $hotel_room_id;
        return $this;
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
     * @return HotelRoom
     * @see object_id
     */
    public function setObjectId(?int $object_id): HotelRoom
    {
        $this->object_id = $object_id;
        return $this;
    }

    /**
     * Возвращает image
     * @return string
     * @see image
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * Устанавливает image
     * @param string $image
     * @return HotelRoom
     * @see image
     */
    public function setImage(string $image): HotelRoom
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Возвращают URL
     * @param $height
     * @param $width
     * @return string
     */
    public function getImageUri($width, $height): string
    {
        if (!$this->image) {
            return "/images/no-image.svg";
        }

        $path_info = pathinfo($this->image);

        $dir = sprintf("%s/%ux%u", $path_info['dirname'], $width, $height);

        if (!file_exists($dir)) {
            Fs::mkdir_recursive($dir);
        }

        return sprintf("/%s/%ux%u/%s.%s?crop=1", $path_info['dirname'], $width, $height, $path_info['filename'], $path_info['extension']);
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
    public function setName(string $name): HotelRoom
    {
        $this->name = $name;
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
     * @return HotelRoom
     * @see description
     */
    public function setDescription(string $description): HotelRoom
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Возвращает price
     * @return float
     * @see price
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Устанавливает price
     * @param float $price
     * @return HotelRoom
     * @see price
     */
    public function setPrice(float $price): HotelRoom
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Возвращает uploaded_file
     * @return string
     * @see uploaded_file
     */
    public function getUploadedFile(): string
    {
        return $this->uploaded_file;
    }

    /**
     * Устанавливает uploaded_file
     * @param string $uploaded_file
     * @return HotelRoom
     * @see uploaded_file
     */
    public function setUploadedFile(string $uploaded_file): HotelRoom
    {
        $this->uploaded_file = $uploaded_file;
        return $this;
    }

    /**
     * Возвращает объект каталога, к которому привязан этот объект. В случае если объект не найден,
     * будет возвращен новый пустой объект CatalogObject
     * @return CatalogObject
     */
    public function getCatalogObject(): CatalogObject
    {
        if (!isset($this->catalog_object) && $this->object_id) {
            $this->catalog_object = CatalogObject::get($this->object_id);
        }

        return $this->catalog_object;
    }
}