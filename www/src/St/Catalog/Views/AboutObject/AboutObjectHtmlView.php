<?php

namespace St\Catalog\Views\AboutObject;

use St\CatalogObject;
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
                <!--
                <div class="section-object__description">
                    <h3>Номера</h3>
                    <div class="sorting-block select-number d-none d-sm-flex flex-wrap align-items-center gap-4 ps-0 pt-0">
                        <a class="sorting-variant active" href="#" onclick="event.preventDefault()">Все номера (5)</a>
                        <a class="sorting-variant" href="#" onclick="event.preventDefault()">Одноместные номера (6)</a>
                        <a class="sorting-variant" href="#" onclick="event.preventDefault()">Семейные номера (2)</a>
                    </div>
                    <ul class="section-catalog__list">
                        <li class="d-flex flex-column flex-sm-row">
                            <div class="section-catalog__wrapper-hotel-image flex-shrink-0">
                                <img alt="Отель" class="w-100 h-100 object-fit-cover" src="/images/mayak.jpg">
                            </div>
                            <div class="section-catalog__wrapper-for-tablet d-lg-flex flex-grow-1">
                                <div class="section-catalog__wrapper-description flex-grow-1">
                                    <h5 class="section-catalog__card-title">Отель "Маяк"</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
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
                                        <span>1 комната, 2 места, 1 кровать, 1 диван</span>
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
                                        <div
                                            class="section-catalog__wrapper-for-day d-flex gap-3 align-items-end align-items-lg-start flex-lg-column">
                                            <div class="section-catalog__price">от 4 200 руб.</div>
                                            <div class="section-catalog__for-number">за номер в сутки</div>
                                        </div>
                                        <a class="btn btn-outline-secondary" href="#">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex flex-column flex-sm-row">
                            <div class="section-catalog__wrapper-hotel-image flex-shrink-0">
                                <img alt="Отель" class="w-100 h-100 object-fit-cover" src="/images/mayak.jpg">
                            </div>
                            <div class="section-catalog__wrapper-for-tablet d-lg-flex flex-grow-1">
                                <div class="section-catalog__wrapper-description flex-grow-1">
                                    <h5 class="section-catalog__card-title">Отель "Маяк"</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
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
                                        <span>1 комната, 2 места, 1 кровать, 1 диван</span>
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
                                        <div
                                            class="section-catalog__wrapper-for-day d-flex gap-3 align-items-end align-items-lg-start flex-lg-column">
                                            <div class="section-catalog__price">от 4 200 руб.</div>
                                            <div class="section-catalog__for-number">за номер в сутки</div>
                                        </div>
                                        <a class="btn btn-outline-secondary" href="#">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex flex-column flex-sm-row">
                            <div class="section-catalog__wrapper-hotel-image flex-shrink-0">
                                <img alt="Отель" class="w-100 h-100 object-fit-cover" src="/images/mayak.jpg">
                            </div>
                            <div class="section-catalog__wrapper-for-tablet d-lg-flex flex-grow-1">
                                <div class="section-catalog__wrapper-description flex-grow-1">
                                    <h5 class="section-catalog__card-title">Отель "Маяк"</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
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
                                        <span>1 комната, 2 места, 1 кровать, 1 диван</span>
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
                                        <div
                                            class="section-catalog__wrapper-for-day d-flex gap-3 align-items-end align-items-lg-start flex-lg-column">
                                            <div class="section-catalog__price">от 4 200 руб.</div>
                                            <div class="section-catalog__for-number">за номер в сутки</div>
                                        </div>
                                        <a class="btn btn-outline-secondary" href="#">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex flex-column flex-sm-row">
                            <div class="section-catalog__wrapper-hotel-image flex-shrink-0">
                                <img alt="Отель" class="w-100 h-100 object-fit-cover" src="/images/mayak.jpg">
                            </div>
                            <div class="section-catalog__wrapper-for-tablet d-lg-flex flex-grow-1">
                                <div class="section-catalog__wrapper-description flex-grow-1">
                                    <h5 class="section-catalog__card-title">Отель "Маяк"</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
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
                                        <span>1 комната, 2 места, 1 кровать, 1 диван</span>
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
                                        <div
                                            class="section-catalog__wrapper-for-day d-flex gap-3 align-items-end align-items-lg-start flex-lg-column">
                                            <div class="section-catalog__price">от 4 200 руб.</div>
                                            <div class="section-catalog__for-number">за номер в сутки</div>
                                        </div>
                                        <a class="btn btn-outline-secondary" href="#">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="empty-block"></div>
                <div class="section-object__description">
                    <h3>Описание</h3>
                    <p>Посмотрите объекты рядом</p>


                </div>
                <div class="empty-block"></div>
                -->

                <div class="section-object__description reviews">
                    <h3>Отзывы (20)</h3>
                    <div class="card-raiting d-flex align-items-center gap-3">
                        <span>4.9</span>
                        <div class="card-raiting__wrapper-stars">
                            <img alt="" src="/images/icons/star.svg">
                            <img alt="" src="/images/icons/star.svg">
                            <img alt="" src="/images/icons/star.svg">
                            <img alt="" src="/images/icons/star.svg">
                            <img alt="" src="/images/icons/semi-star.svg">
                        </div>
                    </div>
                    <div class="sorting-block d-none d-sm-flex flex-wrap align-items-center gap-4 ps-0">
                        Сортировать по:
                        <a class="sorting-variant active" href="#">С высокой оценкой</a>
                        <a class="sorting-variant" href="#">С низкой оценкой</a>
                    </div>
                    <div class="reviews-block review-item">
                        <div class="reviews-block__top d-flex justify-content-between">
                            <div class="reviews-block__person d-flex gap-4 align-items-center">
                                <div class="reviews-block__wrapper-avatar">
                                    <img class="avatar-image" alt="" src="/images/person.png">
                                </div>
                                <div class="reviews-block__wrapper-name">
                                    <div class="reviews-block__name">Евгения Прокопенко</div>
                                    <div class="reviews-block__time">Период отдыха: март 2023</div>
                                </div>
                            </div>
                            <div class="card-raiting d-flex align-items-center gap-3 flex-shrink-0">
                                <span>4.9</span>
                                <div class="card-raiting__wrapper-stars d-flex flex-shrink-0">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/semi-star.svg">
                                </div>
                            </div>
                        </div>
                        <div class="reviews-block__photo-slider owl-carousel">
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                        </div>
                        <div class="review__text">
                            Оказались 2 отдельные кровати, хотя мы с мужем заказывали общую кровать, предложили сдвинуть кровати, но муж решил сделать это сам, так как мы уже вселились с вещами. Пропуск в номер постоянно переставал работать, после долгих прогулок приходилось каждый раз спускаться с третьего этажа вниз, чтобы его активировали, в последний день нам сказали, что пропуск у нас наверно лежал вместе с банковскими карточками (не лежал). Мы попали одним днем отдыха на проходящую в ресторане отеля свадьбу , это был просто ужас, аж стены трясутся. Расположен отель в самом оживленном месте Листвянки, мы были в первый раз, поэтому не знали как там все "вживую". Людям, которые хотят спокойно отдохнуть без толп туристов, я бы не посоветовала, лучше жить чуть дальше, но спокойнее. Выселение тоже проходило странно, уже много лет такого не встречаю - горничная проверяет номер и только после этого тебя выпускают из отеля. В целом проживание в данном месте нам с мужем не понравилось. Компенсировала только близость к началу Большой Байкальской тропы, автовокзалу.
                        </div>
                        <a class="link-warning" href="#">Показать еще</a>
                    </div>
                    <div class="reviews-block review-item">
                        <div class="reviews-block__top d-flex justify-content-between">
                            <div class="reviews-block__person d-flex gap-4 align-items-center">
                                <div class="reviews-block__wrapper-avatar">
                                    <img class="avatar-image" alt="" src="/images/person.png">
                                </div>
                                <div class="reviews-block__wrapper-name">
                                    <div class="reviews-block__name">Евгения Прокопенко</div>
                                    <div class="reviews-block__time">Период отдыха: март 2023</div>
                                </div>
                            </div>
                            <div class="card-raiting d-flex align-items-center gap-3 flex-shrink-0">
                                <span>4.9</span>
                                <div class="card-raiting__wrapper-stars d-flex flex-shrink-0">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/semi-star.svg">
                                </div>
                            </div>
                        </div>
                        <div class="reviews-block__photo-slider owl-carousel">
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                        </div>
                        <div class="review__text">
                            Оказались 2 отдельные кровати, хотя мы с мужем заказывали общую кровать, предложили сдвинуть кровати, но муж решил сделать это сам, так как мы уже вселились с вещами. Пропуск в номер постоянно переставал работать, после долгих прогулок приходилось каждый раз спускаться с третьего этажа вниз, чтобы его активировали, в последний день нам сказали, что пропуск у нас наверно лежал вместе с банковскими карточками (не лежал). Мы попали одним днем отдыха на проходящую в ресторане отеля свадьбу , это был просто ужас, аж стены трясутся. Расположен отель в самом оживленном месте Листвянки, мы были в первый раз, поэтому не знали как там все "вживую". Людям, которые хотят спокойно отдохнуть без толп туристов, я бы не посоветовала, лучше жить чуть дальше, но спокойнее. Выселение тоже проходило странно, уже много лет такого не встречаю - горничная проверяет номер и только после этого тебя выпускают из отеля. В целом проживание в данном месте нам с мужем не понравилось. Компенсировала только близость к началу Большой Байкальской тропы, автовокзалу.
                        </div>
                        <a class="link-warning" href="#">Показать еще</a>
                    </div>
                    <div class="reviews-block review-item">
                        <div class="reviews-block__top d-flex justify-content-between">
                            <div class="reviews-block__person d-flex gap-4 align-items-center">
                                <div class="reviews-block__wrapper-avatar">
                                    <img class="avatar-image" alt="" src="/images/person.png">
                                </div>
                                <div class="reviews-block__wrapper-name">
                                    <div class="reviews-block__name">Евгения Прокопенко</div>
                                    <div class="reviews-block__time">Период отдыха: март 2023</div>
                                </div>
                            </div>
                            <div class="card-raiting d-flex align-items-center gap-3 flex-shrink-0">
                                <span>4.9</span>
                                <div class="card-raiting__wrapper-stars d-flex flex-shrink-0">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/star.svg">
                                    <img alt="" src="/images/icons/semi-star.svg">
                                </div>
                            </div>
                        </div>
                        <div class="reviews-block__photo-slider owl-carousel">
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                            <div class="reviews-block__photo">
                                <img src="/images/review.png" alt="">
                            </div>
                        </div>
                        <div class="review__text">
                            Оказались 2 отдельные кровати, хотя мы с мужем заказывали общую кровать, предложили сдвинуть кровати, но муж решил сделать это сам, так как мы уже вселились с вещами. Пропуск в номер постоянно переставал работать, после долгих прогулок приходилось каждый раз спускаться с третьего этажа вниз, чтобы его активировали, в последний день нам сказали, что пропуск у нас наверно лежал вместе с банковскими карточками (не лежал). Мы попали одним днем отдыха на проходящую в ресторане отеля свадьбу , это был просто ужас, аж стены трясутся. Расположен отель в самом оживленном месте Листвянки, мы были в первый раз, поэтому не знали как там все "вживую". Людям, которые хотят спокойно отдохнуть без толп туристов, я бы не посоветовала, лучше жить чуть дальше, но спокойнее. Выселение тоже проходило странно, уже много лет такого не встречаю - горничная проверяет номер и только после этого тебя выпускают из отеля. В целом проживание в данном месте нам с мужем не понравилось. Компенсировала только близость к началу Большой Байкальской тропы, автовокзалу.
                        </div>
                        <a class="link-warning" href="#">Показать еще</a>
                    </div>
                    <a class="btn btn-outline-secondary" href="#">Показать еще</a>
                </div>
            </div>


        </div>

        <?php
    }


}