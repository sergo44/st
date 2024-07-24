<?php

namespace St;

use Override;
use PDO;

class Review implements IReadDb, \JsonSerializable
{
    /**
     * Идентификатор отзыва
     * @var int|null
     */
    protected ?int $review_id = null;
    /**
     * Идентификатор пользователя, которые добавил отзыв
     * @var int
     */
    protected int $user_id;
    /**
     * Идентификатор объекта, к которому добавлен отзыв
     * @var int
     */
    protected int $object_id;
    /**
     * Дата и время публикации в UTC
     * @var string
     */
    protected string $publish_datetime_utc;
    /**
     * Период отдыха
     * @var string
     */
    protected string $rest_period = "";
    /**
     * Оценка
     * @var int
     */
    protected int $mark = 5;
    /**
     * Текст отзыва
     * @var string
     */
    protected string $review_text = "";
    /**
     * Статус отзыва
     * @var string
     */
    protected string $status = ReviewStatusesEnum::Wait->name;
    /**
     * Новые изображения
     * @var ReviewImage[]
     */
    protected array $new_images = array();
    /**
     * Идентификатор пользователя, который последний изменял статус
     * @var int|null
     */
    protected ?int $processed_user_id = null;
    /**
     * Содержит пользователя, который опубликовал отзыв
     * @var User|null
     */
    protected ?User $user = null;
    /**
     * Изображения, загруженные к объекту (lazy load)
     * @var ReviewImage[]|null
     */
    protected ?array $images = null;

    /**
     * Возвращает отзыв по идентификатору
     * @param int $review_id
     * @param PDO|null $dbh
     * @return Review|null
     */
    public static function get(int $review_id, ?PDO $dbh = null): ?Review
    {
        $dbh = $dbh ?: Db::getReadPDOInstance();

        $sth = $dbh->prepare(/** @lang MariaDB */"SELECT * FROM reviews where review_id = :review_id");

        $sth->execute(array(
            ":review_id" => $review_id
        ));

        $sth->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Review::class);

        return $sth->rowCount() ? $sth->fetch() : null;
    }

    /**
     * @inheritdoc
     * @return array
     */
    #[Override] public function jsonSerialize(): array
    {
        return array(
            "review_id" => $this->review_id,
            "user_id" => $this->user_id,
            "object_id" => $this->object_id,
            "publish_datetime_utc" => $this->publish_datetime_utc,
            "rest_period" => $this->rest_period,
            "mark" => $this->mark,
            "review_text" => $this->review_text,
            "status" => $this->status,
            "images" => $this->getImages()
        );
    }
    /**
     * Возвращает review_id
     * @return int|null
     * @see review_id
     */
    public function getReviewId(): ?int
    {
        return $this->review_id;
    }

    /**
     * Устанавливает review_id
     * @param int|null $review_id
     * @return Review
     * @see review_id
     */
    public function setReviewId(?int $review_id): Review
    {
        $this->review_id = $review_id;
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
     * @return Review
     * @see user_id
     */
    public function setUserId(int $user_id): Review
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * Возвращает object_id
     * @return int
     * @see object_id
     */
    public function getObjectId(): int
    {
        return $this->object_id;
    }

    /**
     * Устанавливает object_id
     * @param int $object_id
     * @return Review
     * @see object_id
     */
    public function setObjectId(int $object_id): Review
    {
        $this->object_id = $object_id;
        return $this;
    }

    /**
     * Возвращает publish_datetime_utc
     * @return string
     * @see publish_datetime_utc
     */
    public function getPublishDatetimeUtc(): string
    {
        return $this->publish_datetime_utc;
    }

    /**
     * Устанавливает publish_datetime_utc
     * @param string $publish_datetime_utc
     * @return Review
     * @see publish_datetime_utc
     */
    public function setPublishDatetimeUtc(string $publish_datetime_utc): Review
    {
        $this->publish_datetime_utc = $publish_datetime_utc;
        return $this;
    }

    public function getPublishDatetime(): ?\DateTime
    {
        return $this->getPublishDatetimeUtc() ? DateTimeHelper::create($this->publish_datetime_utc) : null;
    }

    /**
     * Возвращает rest_period
     * @return string
     * @see rest_period
     */
    public function getRestPeriod(): string
    {
        return $this->rest_period;
    }

    /**
     * Устанавливает rest_period
     * @param string $rest_period
     * @return Review
     * @see rest_period
     */
    public function setRestPeriod(string $rest_period): Review
    {
        $this->rest_period = $rest_period;
        return $this;
    }

    /**
     * Возвращает mark
     * @return int
     * @see mark
     */
    public function getMark(): int
    {
        return $this->mark;
    }

    /**
     * Устанавливает mark
     * @param int $mark
     * @return Review
     * @see mark
     */
    public function setMark(int $mark): Review
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * Возвращает review_text
     * @return string
     * @see review_text
     */
    public function getReviewText(): string
    {
        return $this->review_text;
    }

    /**
     * Устанавливает review_text
     * @param string $review_text
     * @return Review
     * @see review_text
     */
    public function setReviewText(string $review_text): Review
    {
        $this->review_text = $review_text;
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
     * @return Review
     * @see status
     */
    public function setStatus(string $status): Review
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Возвращает processed_user_id
     * @return int|null
     * @see processed_user_id
     */
    public function getProcessedUserId(): ?int
    {
        return $this->processed_user_id;
    }

    /**
     * Устанавливает processed_user_id
     * @param int|null $processed_user_id
     * @return Review
     * @see processed_user_id
     */
    public function setProcessedUserId(?int $processed_user_id): Review
    {
        $this->processed_user_id = $processed_user_id;
        return $this;
    }

    /**
     * Возвращает объект пользователя, который опубликовал отзыв
     * @return User
     * @throws ApplicationError
     */
    public function getUser(): User
    {
        if (!isset($this->user)) {
            $this->user = User::get($this->user_id);
        }

        return $this->user ?: new User();
    }

    /**
     * Добавляет новое изображение к объекту
     * @param ReviewImage $review_image
     * @return $this
     */
    public function addNewImage(ReviewImage $review_image): Review
    {
        $this->new_images[] = $review_image;
        return $this;
    }

    /**
     * Возвращает new_images
     * @return array
     * @see new_images
     */
    public function getNewImages(): array
    {
        return $this->new_images;
    }

    /**
     * Изображения, загруженные к отзыву
     * @return ReviewImage[]
     */
    public function getImages(): array
    {
        if (!isset($this->images)) {
            $sth = Db::getReadPDOInstance()->prepare(/** @lang MariaDB */"SELECT * FROM reviews_image where review_id = :review_id");
            $sth->execute(array(
                ":review_id" => $this->getReviewId()
            ));
            $this->images = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, ReviewImage::class);
        }

        return $this->images;
    }

    /**
     * Возвращает первое изображение
     * @return ReviewImage|null
     */
    public function getFirstImage(): ?ReviewImage
    {
        return sizeof($this->getImages()) ? $this->getImages()[0] : null;
    }

    /**
     * Удаляет изображение из lazy load
     * @param int $review_image_id
     * @return ReviewImage|null
     */
    public function removeImageUsingPrimaryKey(int $review_image_id): ?ReviewImage
    {
        foreach ($this->getImages() as $key => $image) {
            if ($image->getReviewImageId() === $review_image_id) {
                unset($this->images[$key]);
                return $image;
            }
        }

        return null;
    }

}
