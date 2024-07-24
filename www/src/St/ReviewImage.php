<?php
/**
 * Класс описывает изображения, загруженные для отзывов.
 */
namespace St;

class ReviewImage implements \JsonSerializable
{
    /**
     * Идентификатор изображения
     * @var int|null
     */
    protected ?int $review_image_id = 0;
    /**
     * Идентификатор отзыва
     * @var int
     */
    protected int $review_id;
    /**
     * Директория расположения изображения
     * @var string
     */
    protected string $directory;
    /**
     * Имя файла изображения
     * @var string
     */
    protected string $filename;

    /**
     * @inheritdoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "review_image_id" => $this->review_image_id,
            "review_id" => $this->review_id,
            "directory" => $this->directory,
            "filename" => $this->filename
        );
    }

    /**
     * Возвращает review_image_id
     * @return int|null
     * @see review_image_id
     */
    public function getReviewImageId(): ?int
    {
        return $this->review_image_id;
    }

    /**
     * Устанавливает review_image_id
     * @param int|null $review_image_id
     * @return ReviewImage
     * @see review_image_id
     */
    public function setReviewImageId(?int $review_image_id): ReviewImage
    {
        $this->review_image_id = $review_image_id;
        return $this;
    }

    /**
     * Возвращает review_id
     * @return int
     * @see review_id
     */
    public function getReviewId(): int
    {
        return $this->review_id;
    }

    /**
     * Устанавливает review_id
     * @param int $review_id
     * @return ReviewImage
     * @see review_id
     */
    public function setReviewId(int $review_id): ReviewImage
    {
        $this->review_id = $review_id;
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
     * @return ReviewImage
     * @see directory
     */
    public function setDirectory(string $directory): ReviewImage
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
     * @return ReviewImage
     * @see filename
     */
    public function setFilename(string $filename): ReviewImage
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Возвращает URI изображения
     * @param int $w
     * @param int $h
     * @param bool $crop
     * @return string
     */
    public function getUri(int $w, int $h, bool $crop = true): string
    {
        $dir = ltrim(sprintf("%s/%ux%u", $this->getDirectory(), $w, $h), "/");

        if (!file_exists($dir)) {
            Fs::mkdir_recursive($dir);
        }

        return sprintf("/%s/%s?crop=%u", $dir, $this->getFilename(), $crop);
    }
}