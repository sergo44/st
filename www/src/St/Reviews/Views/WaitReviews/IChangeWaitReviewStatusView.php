<?php

namespace St\Reviews\Views\WaitReviews;

use St\Review;

interface IChangeWaitReviewStatusView
{
    /**
     * Устанавливает review
     * @param Review|null $review
     * @return ApproveReviewHtmlStatusView
     * @see review
     */
    public function setReview(?Review $review): IChangeWaitReviewStatusView;

    /**
     * Возвращает review
     * @return Review|null
     * @see review
     */
    public function getReview(): ?Review;
}