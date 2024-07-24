<?php

namespace St\Reviews;

use PDO;
use St\ApplicationError;
use St\Db;
use St\IWriteDb;
use St\Review;

class EditReview implements IWriteDb
{
    /**
     * Отзыв
     * @var Review
     */
    protected Review $review;
    /**
     * Объект PDO для работы с базой данных
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * Конструктор класса
     * @param Review $review
     * @param PDO|null $dbh
     */
    public function __construct(Review $review, ?PDO $dbh = null)
    {
        $this->review = $review;
        $this->dbh = $dbh ?? Db::getWritePDOInstance();
    }

    /**
     * Сохраняет объект в базе данных
     * @throws ApplicationError
     */
    public function save(): EditReview
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
}