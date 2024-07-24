<?php

namespace St\Reviews\Views\WaitReviews;

use Override;

class DeclineReviewHtmlView extends ApproveReviewHtmlStatusView
{
    #[Override] public function out(): void
    {
        ?>

        <?php if ($this->getResult()->isSuccess()): ?>
        <div class="alert alert-success">
            <h5>OK</h5>
            <p>Отзыв успешно скрыт и не будет публиковаться</p>
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