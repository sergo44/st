<?php

namespace St\Sights\Views\AboutSight;

use Override;
use St\ApplicationError;
use St\Auth;
use St\Reviews\ReviewObjectTypesEnum;
use St\Reviews\Views\AddReviewModalDialogHtmlView;
use St\Sights\Sight;
use St\Views\Common\MapHtmlWidget;
use St\Views\HtmlView;
use St\Views\IView;

class AboutSightHtmlView extends HtmlView implements IView
{
    /**
     * Достопримечательность, которую выводим
     * @var Sight
     */
    protected Sight $sight;

    /**
     * Возвращает sight
     * @return Sight
     * @see sight
     */
    public function getSight(): Sight
    {
        return $this->sight;
    }

    /**
     * Устанавливает sight
     * @param Sight $sight
     * @return AboutSightHtmlView
     * @see sight
     */
    public function setSight(Sight $sight): AboutSightHtmlView
    {
        $this->sight = $sight;
        return $this;
    }

    /**
     * @inheritdoc
     * @return void
     * @throws ApplicationError
     */
    #[Override] public function out(): void
    {
        ?>

        <div class="card-raiting d-flex align-items-center gap-3">
            <span>4.9</span>
            <div class="card-raiting__wrapper-stars">
                <img alt="One score" src="/images/icons/star.svg">
                <img alt="Two score" src="/images/icons/star.svg">
                <img alt="Three score" src="/images/icons/star.svg">
                <img alt="Four score" src="/images/icons/star.svg">
                <img alt="Five score" src="/images/icons/semi-star.svg">
            </div>
        </div>
        <div class="section-object__text-under-title">

            <div class="section-object__wrapper-photos d-grid">
                <div class="section-object__wrapper-main-image">
                    <a href="/<?php print $this->sight->getMainImage()->getUri(2000, 2000, true);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>">
                        <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $this->sight->getMainImage()->getUri(633, 633, true)?>">
                    </a>
                </div>

                <?php foreach ($this->getSight()->getAdditionalImages(4) as $key => $image):?>
                    <div class="section-object__wrapper-image<?php if ($key === 3 && sizeof($this->getSight()->getImages()) > 4):?> position-relative<?php endif;?>">
                        <?php if ($key === 3 && sizeof($this->getSight()->getImages()) > 4):?>
                            <a href="/<?php print $image->getUri(2000, 2000);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>" class="overlay-object-foto"><?php print sizeof($this->sight->getImages());?> фото</a>
                            <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $image->getUri(296, 296, true)?>">
                        <?php else: ?>
                            <a href="/<?php print $image->getUri(2000, 2000);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>">
                                <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $image->getUri(296, 296, true)?>">
                            </a>
                        <?php endif;?>


                    </div>
                <?php endforeach; ?>

                <?php if (sizeof($this->getSight()->getImages()) > 0):?>
                <div class="d-none">
                <?php foreach (array_slice($this->getSight()->getImages(), 6) as $image):?>
                    <a href="/<?php print $image->getUri(2000, 2000);?>" data-fancybox="sight-<?php print $this->sight->getSightId();?>">
                        <img alt="" class="w-100 h-100 object-fit-cover" src="/<?php print $image->getUri(296, 296, true)?>">
                    </a>
                <?php endforeach;?>
                </div>
                <?php endif;?>
            </div>
            <div class="section-object__wrapper-description d-grid">
                <div class="section-object__description">
                    <h3>Описание</h3>
                    <?php print $this->sight->getDescription();?>
                </div>
                <?php if ($this->sight->getContactPhone() || $this->sight->getContactEmail() || $this->sight->getWebSiteUrl()):?>
                <div class="we-have">
                    <div class="section-object__check">
                        Уточнить дополнительную информацию
                    </div>
                    <?php if ($this->sight->getContactPhone()):?>
                        <div class="tel-title">Тел.</div>
                        <div class="tel-value"><?php print $this->sight->getContactPhone();?></div>
                    <?php endif; ?>
                    <?php if ($this->sight->getContactEmail()):?>
                        <div class="tel-title">E-mail</div>
                        <div class="tel-value"><?php print $this->escape($this->sight->getContactEmail()); ?></div>
                    <?php endif; ?>
                    <?php if ($this->sight->getWebSiteUrl()):?>
                        <div class="tel-title">Сайт</div>
                        <div class="tel-value"><?php print $this->escape($this->sight->getWebSiteUrl()); ?></div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <div class="section-object__wrapper-prices d-flex flex-wrap">
                    <?php if ($this->sight->getOperatingMode()):?>
                        <div class="section-object__description flex-grow-1">
                            <h3>Режим работы</h3>
                            <div class="price-value"><?php print $this->sight->getOperatingMode();?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->sight->getPrice()):?>
                        <div class="section-object__description flex-grow-1">
                            <h3>Стоимость посещения</h3>
                            <div class="price-value">от <?php print $this->sight->getPrice();?> руб</div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="empty-block"></div>
            </div>
        </div>

        <?php (new MapHtmlWidget($this->sight->getLat(), $this->sight->getLon()))->out(); ?>

        <div class="section-object__description reviews mt-3">
        <h3>Отзывы</h3>
        <?php if (!sizeof($this->sight->getApprovedReviews())): ?>
        <div class="align-content-center">
            <?php if (Auth::getInstance()->get()):?>
                <a class="btn btn-outline-secondary" href="#" data-bs-toggle="modal" data-bs-target="#jsAddReviewModal">Еще никто не оставлял отзыв, будьте первыми. Нажмите сюда, что бы оставить отзыв</a>
            <?php else: ?>
                Для того, что бы оставить отзыв, пожалуйста, войдите на сайте или зарегистрируйтесь, если вы еще это не сделали
            <?php endif; ?>
        </div>
        <?php else: ?>
            <?php foreach ($this->sight->getApprovedReviews() as $review): ?>
                <div class="reviews-block review-item">
                    <div class="reviews-block__top d-flex justify-content-between">
                        <div class="reviews-block__person d-flex gap-4 align-items-center">
                            <div class="reviews-block__wrapper-avatar">
                                <img class="avatar-image" alt="" src="/images/no-image.svg">
                            </div>
                            <div class="reviews-block__wrapper-name">
                                <div class="reviews-block__name"><?php print $this->escape($review->getUser()->getName());?></div>
                                <div class="reviews-block__time">Период отдыха: <?php print $this->escape($review->getRestPeriod());?></div>
                            </div>
                        </div>
                        <div class="card-raiting d-flex align-items-center gap-3 flex-shrink-0">
                            <span><?php print $review->getMark();?></span>
                            <div class="card-raiting__wrapper-stars">
                                <?php for ($i = 1; $i <= $review->getMark(); $i++): ?>
                                    <img alt="Start <?php print $i; ?>" src="/images/icons/star.svg">
                                <?php endfor; ?>

                                <?php for ($i = $review->getMark(); $i > 5; $i++): ?>
                                    <img alt="Start <?php print $i; ?>" src="/images/icons/star-grey.svg">
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (sizeof($review->getImages())):?>

                        <div class="reviews-block__photo-slider owl-carousel">
                            <?php foreach ($review->getImages() as $image):?>
                                <div class="reviews-block__photo m-1">
                                    <a href="<?php print $image->getUri(1000, 1000, false)?>" data-fancybox="review-<?php print $review->getReviewId();?>"><img src="<?php print $image->getUri(293, 158)?>" alt=""></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="review__text"><?php print $this->escape($review->getReviewText());?></div>
                    <a class="link-warning" href="#">Показать еще</a>
                </div>


                <?php endforeach; ?>

                <?php if (Auth::getInstance()->get()): ?>
                    <div class="align-content-center">
                        <a class="btn btn-outline-secondary active" href="#" data-bs-toggle="modal" data-bs-target="#jsAddReviewModal">Добавить свой отзыв</a>
                    </div>
                <?php endif; ?>

                <!-- <div class="d-none sorting-block d-none d-sm-flex flex-wrap align-items-center gap-4 ps-0">
                    Сортировать по:
                    <a class="sorting-variant active" href="#">С высокой оценкой</a>
                    <a class="sorting-variant" href="#">С низкой оценкой</a>
                </div> -->
                </div>
            <?php endif; ?>

                <?php if (Auth::getInstance()->get()):?>
                    <?php (new AddReviewModalDialogHtmlView( Auth::getInstance()->get(), $this->sight->getSightId(), ReviewObjectTypesEnum::Sight ))->out();?>
                <?php endif; ?>

        <?php
    }


}