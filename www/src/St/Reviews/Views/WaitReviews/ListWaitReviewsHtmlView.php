<?php

namespace St\Reviews\Views\WaitReviews;

use Override;
use St\ApplicationError;
use St\Review;
use St\Views\HtmlView;
use St\Views\IView;

class ListWaitReviewsHtmlView extends HtmlView implements IView
{
    /**
     * Отзывы для отображения
     * @var Review[]
     */
    protected array $reviews = array();

    /**
     * Устанавливает reviews
     * @param array $reviews
     * @return ListWaitReviewsHtmlView
     * @see reviews
     */
    public function setReviews(array $reviews): ListWaitReviewsHtmlView
    {
        $this->reviews = $reviews;
        return $this;
    }

    /**
     * @throws ApplicationError
     */
    #[Override] public function out(): void
    {
        ?>

        <?php if (sizeof($this->reviews)):?>

        <ul class="section-ads__list" id="waitReviewsList">
            <?php foreach ($this->reviews as $review):?>
            <li class="mt-4 wait-review-list-item">
                <div class="d-flex gap-4 align-items-center justify-content-between">
                    <div class="d-flex gap-4 border-1">
                        <div class="section-ads__wrapper-photo">
                            <img alt="" src="<?php print $review->getFirstImage() ? $review->getFirstImage()->getUri(142, 142, true) : "/images/no-image.svg";?>" style="width: 142px">
                        </div>

                        <div class="d-flex flex-md-column">
                            <div class="d-flex">
                                <em>
                                    <?php print $this->escape($review->getUser()->getName())?>
                                    <span class="text-muted">
                                    <?php print $review->getPublishDatetime()?->format("d.m.Y"); ?>

                                </span>
                                </em>

                                <div class="ms-4">
                                    <?php for ($i = 1; $i <= $review->getMark(); $i++): ?>
                                        <img alt="Start <?php print $i; ?>" src="/images/icons/star.svg">
                                    <?php endfor; ?>

                                    <?php for ($i = $review->getMark(); $i > 5; $i++): ?>
                                        <img alt="Start <?php print $i; ?>" src="/images/icons/star-grey.svg">
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="d-flex align-l">
                                <?php print $this->escape($review->getReviewText()); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex mt-2 justify-content-end">
                    <ul class="list-inline">
                        <li class="list-inline-item"><a class="d-block mb-2" href="/Reviews/<?php print $review->getReviewId();?>/Approve" data-ajax-url="/Api/Reviews/<?php print $review->getReviewId();?>/Approve" data-manage-review-ajax="1">Допустить публикацию</a></li>
                        | <li class="list-inline-item"><a class="d-block mb-2" href="/Reviews/<?php print $review->getReviewId();?>/Decline" data-ajax-url="/Api/Reviews/<?php print $review->getReviewId();?>/Decline" data-manage-review-ajax="1">Отклонить публикацию</a></li>
                        | <li class="list-inline-item"><a class="d-block mb-2" href="/Reviews/<?php print $review->getReviewId();?>/Edit" data-manage-review-edit="1">Редактировать</a></li>
                    </ul>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php else: ?>
            Отзывы, ожидающие модерацию не найдены
        <?php endif; ?>

        <?php

    }


}