<?php

namespace St\Sights;

use St\ApplicationError;

class SightImage
{
    /**
     * Идентификатор изображения в БД
     * @var int
     */
    protected int $sight_image_id;
    /**
     * Идентификатор объекта достопримечательности
     * @var int
     */
    protected int $sight_id;
    /**
     * Признак главного (основного) изображения
     * @var int
     */
    protected int $main;
    /**
     * Директория, где расположено изображение
     * @var string
     */
    protected string $directory;
    /**
     * Название файла
     * @var string
     */
    protected string $filename;
    /**
     * Координата x1
     * @var int
     */
    protected int $x1;
    /**
     * Координата y1
     * @var int
     */
    protected int $y1;
    /**
     * Координата x2
     * @var int
     */
    protected int $x2;
    /**
     * Координата x2
     * @var int
     */
    protected int $y2;
    /**
     * Соотношение сторон
     * @var string
     */
    protected string $ratio;

    /**
     * Возвращает sight_image_id
     * @return int
     * @see sight_image_id
     */
    public function getSightImageId(): int
    {
        return $this->sight_image_id;
    }

    /**
     * Устанавливает sight_image_id
     * @param int $sight_image_id
     * @return SightImage
     * @see sight_image_id
     */
    public function setSightImageId(int $sight_image_id): SightImage
    {
        $this->sight_image_id = $sight_image_id;
        return $this;
    }

    /**
     * Возвращает sight_id
     * @return int
     * @see sight_id
     */
    public function getSightId(): int
    {
        return $this->sight_id;
    }

    /**
     * Устанавливает sight_id
     * @param int $sight_id
     * @return SightImage
     * @see sight_id
     */
    public function setSightId(int $sight_id): SightImage
    {
        $this->sight_id = $sight_id;
        return $this;
    }

    /**
     * Возвращает main
     * @return int
     * @see main
     */
    public function getMain(): int
    {
        return $this->main;
    }

    /**
     * Устанавливает main
     * @param int $main
     * @return SightImage
     * @see main
     */
    public function setMain(int $main): SightImage
    {
        $this->main = $main;
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
     * @return SightImage
     * @see directory
     */
    public function setDirectory(string $directory): SightImage
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Возвращает filename
     * @return string
     * @see filename
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Устанавливает filename
     * @param string $filename
     * @return SightImage
     * @see filename
     */
    public function setFilename(string $filename): SightImage
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
     * @return SightImage
     * @see x1
     */
    public function setX1(int $x1): SightImage
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
     * @return SightImage
     * @see y1
     */
    public function setY1(int $y1): SightImage
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
     * @return SightImage
     * @see x2
     */
    public function setX2(int $x2): SightImage
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
     * @return SightImage
     * @see y2
     */
    public function setY2(int $y2): SightImage
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
     * @return SightImage
     * @see ratio
     */
    public function setRatio(string $ratio): SightImage
    {
        $this->ratio = $ratio;
        return $this;
    }

    /**
     * Возвращает URI изображения
     * @throws ApplicationError
     */
    public function getUri(int $w, int $h, bool $crop = true): string
    {
        $directory = sprintf("%s/%ux%u", $this->getDirectory(), $w, $h);

        if (!file_exists($directory)) {
            mkdir($directory, ~0777 & ST_DEFAULT_UMASK) || throw new ApplicationError(sprintf("Can't create %s ", $directory));
        }

        return sprintf(
            "%s/%ux%u/%s?x1=%u&y1=%u&x2=%u&y2=%u&crop=%u",
            $this->getDirectory(),
            $w,
            $h,
            $this->getFilename(),
            $this->getX1(),
            $this->getY1(),
            $this->getX2(),
            $this->getY2(),
            $crop
        );
    }

}