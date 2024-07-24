<?php

namespace St\Reviews\Views\WaitReviews;

use Override;
use St\Review;
use St\Views\HtmlView;
use St\Views\IView;

class ApproveReviewHtmlStatusView extends HtmlView implements IView, IChangeWaitReviewStatusView
{
    /**
     * Отзыв
     * @var Review|null
     */
    protected ?Review $review = null;

    /**
     * Устанавливает review
     * @param Review|null $review
     * @return ApproveReviewHtmlStatusView
     * @see review
     */
    public function setReview(?Review $review): ApproveReviewHtmlStatusView
    {
        $this->review = $review;
        return $this;
    }

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
     * @inheritdoc
     * @return void
     */
    #[Override] public function out(): void
    {
        ?>

        <?php if ($this->getResult()->isSuccess()): ?>
        <div class="alert alert-success">
            <h5>OK</h5>
            <p>Отзыв успешно одобрен и допущен к публикации</p>
            <p><a href="/Reviews/Wait">Вернуться к списку ожидающих проверку отзывов</a></p>
        </div>
        <?php else: ?>
        <div class="alert alert-success">
            <h5>Ошибка</h5>
            <ul>
                <li><?php print $this->getResult()->getErrorsAsString("</li><li>"); ?></li>
            </ul>
            <p><a href="/Reviews/Wait">Вернуться к списку ожидающих проверку отзывов</a></p>
        </div>
        <?php endif; ?>

        <?php
    }

}