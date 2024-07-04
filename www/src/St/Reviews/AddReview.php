<?php
/**
 * Метод добавления отзыва к объекту
 */
namespace St\Reviews;

use PDO;
use St\IWriteDb;
use St\Result;
use St\Review;
use St\ReviewStatusesEnum;

class AddReview implements IWriteDb
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
     */
    public function __construct(PDO $dbh, Review $review)
    {
        $this->review = $review;
        $this->dbh = $dbh;
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
    public function saveToDb(): AddReview
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
}