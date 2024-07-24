<?php

namespace St\Reviews\Views\WaitReviews;

use St\Review;
use St\Views\IView;
use St\Views\JsonView;

class ApproveReviewJsonView extends JsonView implements \JsonSerializable, IChangeWaitReviewStatusView, IView
{
    /**
     * Отзыв, который изменятся
     * @var Review|null
     */
    protected ?Review $review = null;

    /**
     * Возвращает review
     * @return Review|null
     * @see review
     */
    public function getReview(): ?Review
    {
        return $this->review;
    }

    /**
     * Устанавливает review
     * @param Review|null $review
     * @return ApproveReviewJsonView
     * @see review
     */
    public function setReview(?Review $review): ApproveReviewJsonView
    {
        $this->review = $review;
        return $this;
    }


    #[\Override] public function jsonSerialize(): mixed
    {
        return array(
            "result" => $this->getResult(),
            "review" => $this->getReview()
        );
    }


}