<?php

namespace St;

class Image
{
    /**
     * Идентификатор изображения
     * @var int|null
     */
    protected ?int $image_id = null;
    /**
     * Идентификатор объекта
     * @var int|null
     */
    protected ?int $object_id = 0;
    /**
     * Признак, является ли изображение основным, где
     *  1 - Основное изображение
     *  2 - Дополнительное изображение
     * @var int
     */
    protected int $primary = 0;
    /**
     * Директория, куда сохраняются данные
     * @var string
     */
    protected string $directory;
    /**
     * Название файла
     * @var string|null
     */
    protected ?string $filename = null;
    /**
     * Координата X1 (левой точки)
     * @var int
     */
    protected int $x1 = 0;
    /**
     * Координата Y1 (правая точка)
     * @var int
     */
    protected int $y1 = 0;
    /**
     * Координата X2 (правая точка)
     * @var int
     */
    protected int $x2 = 0;
    /**
     * Координата Y2 (правая точка)
     * @var int
     */
    protected int $y2 = 0;
    /**
     * Отношение сторон, которое необходимо
     * @var string
     */
    protected string $ratio = "";

    /**
     * Возвращает image_id
     * @return int|null
     * @see image_id
     */
    public function getImageId(): ?int
    {
        return $this->image_id;
    }

    /**
     * Устанавливает image_id
     * @param int|null $image_id
     * @return Image
     * @see image_id
     */
    public function setImageId(?int $image_id): Image
    {
        $this->image_id = $image_id;
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
     * @return Image
     * @see object_id
     */
    public function setObjectId(?int $object_id): Image
    {
        $this->object_id = $object_id;
        return $this;
    }

    /**
     * Возвращает primary
     * @return int
     * @see primary
     */
    public function getPrimary(): int
    {
        return $this->primary;
    }

    /**
     * Устанавливает primary
     * @param int $primary
     * @return Image
     * @see primary
     */
    public function setPrimary(int $primary): Image
    {
        $this->primary = $primary;
        return $this;
    }

    /**
     * Возвращает directory
     * @return string
     * @see directory
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * Устанавливает directory
     * @param string $directory
     * @return Image
     * @see directory
     */
    public function setDirectory(string $directory): Image
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Возвращает filename
     * @return string|null
     * @see filename
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Устанавливает filename
     * @param string|null $filename
     * @return Image
     * @see filename
     */
    public function setFilename(?string $filename): Image
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Возвращает x1
     * @return int
     * @see x1
     */
    public function getX1(): int
    {
        return $this->x1;
    }

    /**
     * Устанавливает x1
     * @param int $x1
     * @return Image
     * @see x1
     */
    public function setX1(int $x1): Image
    {
        $this->x1 = $x1;
        return $this;
    }

    /**
     * Возвращает y1
     * @return int
     * @see y1
     */
    public function getY1(): int
    {
        return $this->y1;
    }

    /**
     * Устанавливает y1
     * @param int $y1
     * @return Image
     * @see y1
     */
    public function setY1(int $y1): Image
    {
        $this->y1 = $y1;
        return $this;
    }

    /**
     * Возвращает x2
     * @return int
     * @see x2
     */
    public function getX2(): int
    {
        return $this->x2;
    }

    /**
     * Устанавливает x2
     * @param int $x2
     * @return Image
     * @see x2
     */
    public function setX2(int $x2): Image
    {
        $this->x2 = $x2;
        return $this;
    }

    /**
     * Возвращает y2
     * @return int
     * @see y2
     */
    public function getY2(): int
    {
        return $this->y2;
    }

    /**
     * Устанавливает y2
     * @param int $y2
     * @return Image
     * @see y2
     */
    public function setY2(int $y2): Image
    {
        $this->y2 = $y2;
        return $this;
    }

    /**
     * Возвращает ratio
     * @return string
     * @see ratio
     */
    public function getRatio(): string
    {
        return $this->ratio;
    }

    /**
     * Устанавливает ratio
     * @param string $ratio
     * @return Image
     * @see ratio
     */
    public function setRatio(string $ratio): Image
    {
        $this->ratio = $ratio;
        return $this;
    }

    /**
     * Возвращает URI изображения заданной ширины, высоты
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return string
     */
    public function getUri(int $width, int $height, bool $crop = true): string
    {
        $dir = sprintf("%s/%ux%u/", $this->directory, $width, $height);
        if (!file_exists($dir)) {
            Fs::mkdir_recursive($dir);
        }

        return sprintf("/%s%s?crop=%u&x1=%u&y1=%u&x2=%u&y2=%u", $dir, $this->filename, $crop, $this->x1, $this->y1, $this->x2, $this->y2);
    }

}