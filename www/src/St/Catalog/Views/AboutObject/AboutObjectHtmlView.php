<?php

namespace St\Catalog\Views\AboutObject;

use St\ApplicationError;
use St\Auth;
use St\Catalog\Views\AboutObject\Widgets\OrderRoomModalDialogHtmlWidget;
use St\CatalogObject;
use St\Reviews\Views\AddReviewModalDialogHtmlView;
use St\User;
use St\Views\HtmlView;
use St\Views\IView;

class AboutObjectHtmlView extends HtmlView implements IView
{
    /**
     * Объект, который необходимо отобразить
     * @var CatalogObject
     */
    protected CatalogObject $catalog_object;

    /**
     * Возвращает catalog_object
     * @return CatalogObject
     * @see catalog_object
     */
    public function getCatalogObject(): CatalogObject
    {
        return $this->catalog_object;
    }

    /**
     * Устанавливает catalog_object
     * @param CatalogObject $catalog_object
     * @return AboutObjectHtmlView
     * @see catalog_object
     */
    public function setCatalogObject(CatalogObject $catalog_object): AboutObjectHtmlView
    {
        $this->catalog_object = $catalog_object;
        return $this;
    }

    /**
     * @throws ApplicationError
     */
    #[\Override] public function out(): void
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
            <?php print $this->catalog_object->getAddressLines();?>
            <div class="section-object__wrapper-photos d-grid">
                <div class="section-object__wrapper-main-image">
                    <img alt="" class="w-100 h-100 object-fit-cover" src="<?php print $this->catalog_object->getFirstImage()->getUri(633, 633, true)?>">
                </div>

                <?php foreach ($this->catalog_object->getAdditionalImages(4) as $image):?>
                    <div class="section-object__wrapper-image">
                        <img alt="" class="w-100 h-100 object-fit-cover" src="<?php print $image->getUri(296, 296, true)?>">
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="section-object__wrapper-description d-grid">
                <div class="section-object__description">
                    <h3>Описание</h3>
                    <?php print $this->catalog_object->getDescription();?>
                </div>
                <div class="we-have">
                    <div class="section-object__check">
                        Уточнить наличие свободных мест и стоимость
                    </div>
                    <div class="tel-title">Тел.</div>
                    <div class="tel-value"><?php print $this->catalog_object->getContactPhone();?></div>
                    <?php if ($this->catalog_object->getContactEmail()):?>
                        <div class="tel-title">E-mail</div>
                        <div class="tel-value"><?php print $this->escape($this->catalog_object->getContactEmail()); ?></div>
                    <?php endif; ?>
                    <?php if ($this->catalog_object->getWebSiteUrl()):?>
                        <div class="tel-title">Сайт</div>
                        <div class="tel-value"><?php print $this->escape($this->catalog_object->getWebSiteUrl()); ?></div>
                    <?php endif; ?>
                    <div class="tel-title">Сайт</div>
                    <div class="tel-value"></div>
                </div>
                <!-- <div class="section-object__description">
                  <h3>Услуги и удобства в отеле</h3>
                   <ul class="section-object__advantages d-grid">
                       <li class="d-flex gap-3 align-items-center">
                           <div class="section-object__advantages__wrapper-icon d-flex align-items-center justify-content-center"
                                style="width: 2.6rem; height: 2.6rem">
                               <img alt="" class="w-100 h-100 object-fit-contain" src="/images/icons/shezlong.svg">
                           </div>
                           Бесплатная парковка
                       </li>
                       <li class="d-flex gap-3 align-items-center">
                           <div class="section-object__advantages__wrapper-icon d-flex align-items-center justify-content-center"
                                style="width: 2.6rem; height: 2.6rem">
                               <img alt="" class="w-100 h-100 object-fit-contain" src="/images/icons/shezlong.svg">
                           </div>
                           Игровой комплекс на открытом воздухе
                       </li>
                       <li class="d-flex gap-3 align-items-center">
                           <div class="section-object__advantages__wrapper-icon d-flex align-items-center justify-content-center"
                                style="width: 2.6rem; height: 2.6rem">
                               <img alt="" class="w-100 h-100 object-fit-contain" src="/images/icons/shezlong.svg">
                           </div>
                           Бесплатная парковка
                       </li>
                       <li class="d-flex gap-3 align-items-center">
                           <div class="section-object__advantages__wrapper-icon d-flex align-items-center justify-content-center"
                                style="width: 2.6rem; height: 2.6rem">
                               <img alt="" class="w-100 h-100 object-fit-contain" src="/images/icons/shezlong.svg">
                           </div>
                           Игровой комплекс на открытом воздухе
                       </li>
                       <li class="d-flex gap-3 align-items-center">
                           <div class="section-object__advantages__wrapper-icon d-flex align-items-center justify-content-center"
                                style="width: 2.6rem; height: 2.6rem">
                               <img alt="" class="w-100 h-100 object-fit-contain" src="/images/icons/shezlong.svg">
                           </div>
                           Бесплатная парковка
                       </li>
                       <li class="d-flex gap-3 align-items-center">
                           <div class="section-object__advantages__wrapper-icon d-flex align-items-center justify-content-center"
                                style="width: 2.6rem; height: 2.6rem">
                               <img alt="" class="w-100 h-100 object-fit-contain" src="/images/icons/shezlong.svg">
                           </div>
                           Бесплатная парковка
                       </li>
                   </ul>
                   <a class="link-warning" href="#">Показать все услуги (15)</a>
               </div>

                <div class="empty-block"></div>-->
                <div class="section-object__wrapper-prices d-flex flex-wrap">
                    <div class="section-object__description flex-grow-1">
                        <h3>Цены за номер</h3>
                        <div class="price-value">от <?php print $this->catalog_object->getStartPrice();?> руб</div>
                    </div>
                    <div class="d-none
                    section-object__description flex-grow-1">
                        <h3>Цена за доп.место</h3>
                        <div class="price-value">от 2 000 руб.</div>
                    </div>
                </div>
                <div class="empty-block"></div>

                <?php if (sizeof($this->catalog_object->getHotelRooms())):?>

                <div class="section-object__description">
                    <h3>Номера</h3>
                    <!-- <div class="sorting-block select-number d-none d-sm-flex flex-wrap align-items-center gap-4 ps-0 pt-0">
                        <a class="sorting-variant active" href="#" onclick="event.preventDefault()">Все номера (5)</a>
                        <a class="sorting-variant" href="#" onclick="event.preventDefault()">Одноместные номера (6)</a>
                        <a class="sorting-variant" href="#" onclick="event.preventDefault()">Семейные номера (2)</a>
                    </div> -->
                    <ul class="section-catalog__list">
                        <?php foreach ($this->catalog_object->getHotelRooms() as $hotel_room):?>

                            <li class="d-flex flex-column flex-sm-row">
                                <div class="section-catalog__wrapper-hotel-image flex-shrink-0" style="height: 191px">
                                    <img alt="Отель" class="w-100 h-100 object-fit-cover" src="<?php print $hotel_room->getImageUri(287, 191)?>">
                                </div>
                                <div class="section-catalog__wrapper-for-tablet w-100 d-lg-flex flex-grow-1">
                                    <div class="section-catalog__wrapper-description flex-grow-1 w-100">
                                        <h5 class="section-catalog__card-title"><?php print $this->escape($hotel_room->getName())?></h5>
                                        <div class="card-raiting d-flex align-items-center gap-3 d-none">
                                            <span>4.9</span>
                                            <div class="card-raiting__wrapper-stars">
                                                <img alt="" src="/images/icons/star.svg">
                                                <img alt="" src="/images/icons/star.svg">
                                                <img alt="" src="/images/icons/star.svg">
                                                <img alt="" src="/images/icons/star.svg">
                                                <img alt="" src="/images/icons/semi-star.svg">
                                            </div>
                                        </div>
                                        <div class="card__wrapper-house card-in-object d-flex align-items-center gap-3 mt-2">
                                            <span><?php print  print $this->escape($hotel_room->getDescription());?></span>
                                        </div>
                                        <ul class="card__adv-list d-flex flex-wrap ">
                                            <li>Wi-Fi</li>
                                            <li>Кофе</li>
                                            <li>Обслуживание номеров</li>
                                            <li>Кондиционер</li>
                                            <li>Wi-Fi</li>
                                        </ul>
                                    </div>

                                    <div class="section-catalog__wrapper-card-price flex-shrink-0 d-flex align-items-center">
                                        <div class="section-catalog__price__wrapper w-100">
                                            <div class="section-catalog__wrapper-for-day d-flex gap-3 align-items-end align-items-lg-start flex-lg-column">
                                                <div class="section-catalog__price">от <?php print $hotel_room->getPrice();?> руб.</div>
                                                <div class="section-catalog__for-number">за номер в сутки</div>
                                            </div>
                                            <a class="btn btn-outline-secondary" href="#" data-hotel-room-id="<?php print (int)$hotel_room->getHotelRoomId();?>" data-bs-target="#jsOrderRoomModal" data-bs-toggle="modal">Забронировать</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <div class="empty-block"></div>
                <div class="section-object__description">
                    <h3>Описание</h3>
                    <p>Посмотрите объекты рядом</p>
                </div>
                <div class="empty-block"></div>


                <div class="section-object__description reviews">
                    <h3>Отзывы</h3>
                    <?php if (!sizeof($this->catalog_object->getAllReviews())): ?>
                        <div class="align-content-center">
                            <?php if (Auth::getInstance()->get()):?>
                                <a class="btn btn-outline-secondary" href="#" data-bs-toggle="modal" data-bs-target="#jsAddReviewModal">Еще никто не оставлял отзыв, будьте первыми. Нажмите сюда, что бы оставить отзыв</a>
                            <?php else: ?>
                                Для того, что бы оставить отзыв, пожалуйста, войдите на сайте или зарегистрируйтесь, если вы еще это не сделали
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <?php foreach ($this->catalog_object->getAllReviews() as $review): ?>
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
                                            <div class="reviews-block__photo">
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

                        <div class="d-none sorting-block d-none d-sm-flex flex-wrap align-items-center gap-4 ps-0">
                            Сортировать по:
                            <a class="sorting-variant active" href="#">С высокой оценкой</a>
                            <a class="sorting-variant" href="#">С низкой оценкой</a>
                        </div>



                    </div>
                <?php endif; ?>
            </div>


        </div>

        <?php (new OrderRoomModalDialogHtmlWidget(Auth::getInstance()->get()))->out(); ?>

        <?php if (Auth::getInstance()->get()):?>
            <?php (new AddReviewModalDialogHtmlView( Auth::getInstance()->get(), $this->catalog_object ))->out();?>
        <?php endif; ?>

        <?php


    }


}