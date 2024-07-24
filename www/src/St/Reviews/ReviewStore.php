<?php
/**
 * Метод добавления отзыва к объекту
 */
namespace St\Reviews;

use PDO;
use St\ApplicationError;
use St\Db;
use St\Fs;
use St\IWriteDb;
use St\Result;
use St\Review;
use St\ReviewStatusesEnum;

class ReviewStore implements IWriteDb
{
    /**
     * Объект отзыва, который добавляется в базу данных
     * @var Review
     */
    protected Review $review;
    /**
     * Объект PDO, который используется для соединения с СУБД
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор объекта
     * @param Review $review
     * @param PDO|null $dbh
     */
    public function __construct(Review $review,  ?PDO $dbh = null)
    {
        $this->review = $review;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    public function check(Result $result): Result
    {
        if ($this->review->getUserId() <= 0) {
            $result->addError("Идентификатор пользователя не задан", "user_id");
        }

        if ($this->review->getObjectId() <= 0) {
            $result->addError("Идентификатор объекта не задан", "object_id");
        }

        if (!$this->review->getPublishDatetimeUtc()) {
            $result->addError("Дата и время публикации отзыва не заданы", "publish_datetime_utc");
        }

        if (!$this->review->getRestPeriod()) {
            $result->addError("Вы не указали период отдыха", "rest_period");
        }

        if ($this->review->getMark() < 1 || $this->review->getMark() > 5) {
            $result->addError("Оценка не указана или указана неверно");
        }

        if (!trim($this->review->getReviewText())) {
            $result->addError("Вы не указали текст отзыва, пожалуйста, напишите хотя бы пару строчек и поделитесь своими эмоциями");
        }

        if (!defined(ReviewStatusesEnum::class . "::" . $this->review->getStatus())) {
            $result->addError("Произошла нетипичная ошибка - статус отзыва указан неверно");
        }

        return $result;
    }

    /**
     * Метод добавления нового отзыва
     * @return $this
     */
    public function add(): ReviewStore
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            INSERT INTO reviews
            (
                review_id, 
                user_id, 
                object_id, 
                publish_datetime_utc, 
                rest_period, 
                mark, 
                review_text, 
                status, 
                processed_user_id
            )
            VALUES 
            (
                :review_id,
                :user_id,
                :object_id,
                :publish_datetime_utc,
                :rest_period,
                :mark,
                :review_text,
                :status,
                :processed_user_id                
            )
        ");

        $sth->execute(array(
            ":review_id" => $this->review->getReviewId(),
            ":user_id" => $this->review->getUserId(),
            ":object_id" => $this->review->getObjectId(),
            ":publish_datetime_utc" => $this->review->getPublishDatetimeUtc(),
            ":rest_period" => $this->review->getRestPeriod(),
            ":mark" => $this->review->getMark(),
            ":review_text" => $this->review->getReviewText(),
            ":status" => $this->review->getStatus(),
            ":processed_user_id" => $this->review->getProcessedUserId()
        ));

        $this->review->setReviewId($this->dbh->lastInsertId());

        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            INSERT INTO reviews_image            
            (
                review_image_id, 
                review_id,
                directory, 
                filename
            )
            VALUES
            (
                NULL,
                :review_id,
                :directory,
                :filename
            )
        ");

        foreach ($this->review->getNewImages() as $image) {

            $image
                ->setReviewId( $this->review->getReviewId() )
            ;
            $sth->execute(array(
                ":review_id" => $image->getReviewId(),
                ":directory" => $image->getDirectory(),
                ":filename" => $image->getFilename()
            ));

            $image
                ->setReviewImageId( $this->dbh->lastInsertId() )
            ;

        }

        return $this;
    }

    /**
     * Обновляет данные об отзыве
     * @return ReviewStore
     * @throws ApplicationError
     */
    public function update(): ReviewStore
    {
        $sth = $this->dbh->prepare(/** @lang MariaDB */"
            UPDATE
                reviews 
            SET
                user_id = :user_id,
                object_id = :object_id,
                publish_datetime_utc = :publish_datetime_utc,
                rest_period = :rest_period,
                mark = :mark,
                review_text = :review_text,
                status = :status,
                processed_user_id = :processed_user_id
            WHERE
                review_id = :review_id
        ");

        $sth->execute(array(
            ":user_id" => $this->review->getUser()->getUserId(),
            ":object_id" => $this->review->getObjectId(),
            ":publish_datetime_utc" => $this->review->getPublishDatetimeUtc(),
            ":rest_period" => $this->review->getRestPeriod(),
            ":mark" => $this->review->getMark(),
            ":review_text" => $this->review->getReviewText() ,
            ":status" => $this->review->getStatus(),
            ":processed_user_id" => $this->review->getProcessedUserId(),
            ":review_id" => $this->review->getReviewId(),
        ));

        return $this;
    }

    /**
     * Удаляет изображение по идентификатору
     * @param int $review_image_id
     * @return $this
     */
    public function removeImageUsingPrimaryKey(int $review_image_id): ReviewStore
    {
        $image = $this->review->removeImageUsingPrimaryKey($review_image_id);

        if ($image) {
            Fs::purge_thumbs($image->getDirectory(), $image->getFilename());

            $sth = $this->dbh->prepare(/** @lang MariaDB */"DELETE FROM reviews_image where review_image_id = :review_image_id");
            $sth->execute(array(
                ":review_image_id" => $review_image_id
            ));
        }

        return $this;
    }

}