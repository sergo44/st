<?php

namespace St\Catalog\Views\ShowObjects;

use St\CatalogObject;
use St\Views\HtmlView;
use St\Views\IView;

class ShowObjectsHtmlView extends HtmlView implements IView
{
    /**
     * Объекты для отображения
     * @var CatalogObject[]
     */
    protected array $catalog_objects;

    /**
     * Возвращает catalog_objects
     * @return array
     * @see catalog_objects
     */
    public function getCatalogObjects(): array
    {
        return $this->catalog_objects;
    }

    /**
     * Устанавливает catalog_objects
     * @param array $catalog_objects
     * @return ShowObjectsHtmlView
     * @see catalog_objects
     */
    public function setCatalogObjects(array $catalog_objects): ShowObjectsHtmlView
    {
        $this->catalog_objects = $catalog_objects;
        return $this;
    }

    /**
     * Отображение шаблона
     * @return void
     */
    #[\Override] public function out(): void
    {
        ?>

        <div class="container">
            <div class="section-catalog__top d-flex">
                <div class="section-catalog__wrapper-left d-none d-lg-block">
                    <div class="section-catalog__top__map d-flex flex-shrink-0 align-items-center justify-content-center">
                        <a class="btn btn-outline-secondary d-flex gap-2 w-100 mt-0" href="/Catalog/Map">
                            <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 10.625C11.3807 10.625 12.5 9.50571 12.5 8.125C12.5 6.74429 11.3807 5.625 10 5.625C8.61929 5.625 7.5 6.74429 7.5 8.125C7.5 9.50571 8.61929 10.625 10 10.625Z"
                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path
                                    d="M16.25 8.125C16.25 13.75 10 18.125 10 18.125C10 18.125 3.75 13.75 3.75 8.125C3.75 6.4674 4.40848 4.87769 5.58058 3.70558C6.75269 2.53348 8.3424 1.875 10 1.875C11.6576 1.875 13.2473 2.53348 14.4194 3.70558C15.5915 4.87769 16.25 6.4674 16.25 8.125V8.125Z"
                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Показать на карте</a>
                    </div>
                </div>
                <div class="section-catalog__wrapper-sort flex-grow-1">
                    <div class="section-catalog__top__sort mt-5 d-flex align-items-center justify-content-between flex-grow-1">
                        <div class="section-catalog__founded">
                            <span>Найдено <?php print sizeof($this->getCatalogObjects());?> варианта</span>
                            Показано <?php print min(10, sizeof($this->getCatalogObjects()));?> из <?php print sizeof($this->getCatalogObjects());?> -->
                        </div>
                        <a class="btn btn-outline-secondary d-flex gap-2 mt-0" href="/Catalog/Objects/Add"
                           style="padding-left: 2rem;padding-right: 2rem;">
                            <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.125 10H16.875" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 3.125V16.875" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Добавить объект</a>
                    </div>
                    <div class="section-catalog__wrapper-filter-buttons d-flex gap-5 d-lg-none justify-content-between mt-5 mb-2">
                        <a class="btn btn-outline-secondary d-flex gap-2 mt-0 w-100" data-bs-target="#filterModal"
                           data-bs-toggle="modal" href="#" style="padding-left: 2rem;padding-right: 2rem;">
                            <svg fill="none" height="2rem" viewBox="0 0 21 20" width="2.1rem" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.3125 13.4375L3.875 13.4375" stroke="#170B00" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path d="M17.625 13.4375L15.4375 13.4375" stroke="#170B00" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path
                                    d="M13.875 15C14.7379 15 15.4375 14.3004 15.4375 13.4375C15.4375 12.5746 14.7379 11.875 13.875 11.875C13.0121 11.875 12.3125 12.5746 12.3125 13.4375C12.3125 14.3004 13.0121 15 13.875 15Z"
                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.3125 6.56257L3.875 6.5625" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.625 6.5625L10.4375 6.56257" stroke="#170B00" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path
                                    d="M8.875 8.125C9.73794 8.125 10.4375 7.42544 10.4375 6.5625C10.4375 5.69956 9.73794 5 8.875 5C8.01206 5 7.3125 5.69956 7.3125 6.5625C7.3125 7.42544 8.01206 8.125 8.875 8.125Z"
                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>

                        <a class="btn btn-outline-secondary d-flex gap-2 w-100 mt-0" href="/Catalog/Map">
                            <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10 10.625C11.3807 10.625 12.5 9.50571 12.5 8.125C12.5 6.74429 11.3807 5.625 10 5.625C8.61929 5.625 7.5 6.74429 7.5 8.125C7.5 9.50571 8.61929 10.625 10 10.625Z"
                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path
                                    d="M16.25 8.125C16.25 13.75 10 18.125 10 18.125C10 18.125 3.75 13.75 3.75 8.125C3.75 6.4674 4.40848 4.87769 5.58058 3.70558C6.75269 2.53348 8.3424 1.875 10 1.875C11.6576 1.875 13.2473 2.53348 14.4194 3.70558C15.5915 4.87769 16.25 6.4674 16.25 8.125V8.125Z"
                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Показать на карте</a>
                    </div>

                    <?php if (sizeof($this->catalog_objects)):?>
                        <div class="sorting-block d-none d-sm-flex flex-wrap align-items-center gap-4">
                            Сортировать по:
                            <a class="sorting-variant active" href="#">Популярные</a>
                            <a class="sorting-variant" href="#">Сначала дешевые</a>
                            <a class="sorting-variant" href="#">Сначала дорогие</a>
                        </div>
                        <div
                            class="btn-group sorting-block-mobile d-flex d-sm-none align-items-center gap-2 pt-4 pb-4 position-relative">
                            <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.25 13.125L14.375 16.25L17.4999 13.1255" stroke="#170B00" stroke-linecap="round"
                                      stroke-linejoin="round"/>
                                <path d="M14.375 8.75V16.25" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.75 10H9.37492" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.75 5H14.3749" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.75 15H8.125" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <button aria-expanded="false" class="dropdown-toggle" data-bs-display="static" data-bs-toggle="dropdown"
                                    type="button">
                                Популярное
                            </button>
                            <ul
                                class=" dropdown-menu dropdown-menu-lg-end sorting-block-mobile__drop-down p-4  mt-0 position-absolute top-100 rounded-3 shadow-lg z-3">
                                <li class="mb-3"><a class="dropdown-item d-flex align-items-center gap-2 " href="#">
                                        <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.25 13.125L14.375 16.25L17.4999 13.1255" stroke="#170B00" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M14.375 8.75V16.25" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 10H9.37492" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 5H14.3749" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 15H8.125" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Популярное
                                    </a></li>
                                <li class="mb-3"><a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                        <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.25 6.875L14.375 3.75L17.4999 6.87445" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.375 11.25V3.75" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 10H9.37492" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 5H8.12492" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 15H14.3749" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Сначала дешевые
                                    </a></li>
                                <li class="mb-3"><a class="dropdown-item d-flex align-items-center gap-2 " href="#">
                                        <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.25 13.125L14.375 16.25L17.4999 13.1255" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.375 8.75V16.25" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 10H9.37492" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 5H14.3749" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 15H8.125" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Сначала дорогие
                                    </a></li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <ul class="section-catalog__list">
                        <?php foreach ($this->getCatalogObjects() as $catalog_object):?>
                            <li class="d-flex flex-column flex-sm-row">

                                <div class="section-catalog__wrapper-hotel-image flex-shrink-0">
                                    <img alt="Отель" class="w-100 h-100 object-fit-cover" src="<?php print $catalog_object->getFirstImage()->getUri(214, 214, true)?>">
                                </div>
                                <div class="section-catalog__wrapper-for-tablet d-lg-flex">
                                    <div class="section-catalog__wrapper-description">
                                        <h5 class="section-catalog__card-title"><?php print $this->escape($catalog_object->getName())?></h5>
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
                                        <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                            <span><?php print $this->escape($catalog_object->getDescription())?></span>
                                        </div>
                                        <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                                            <img alt="" src="/images/icons/geo.svg">
                                            <span><?php print $catalog_object->getAddressLines();?></span>
                                        </div>
                                        <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                                            <img alt="" src="/images/icons/tag.svg">
                                            <span><?php print $this->escape($catalog_object->getIncludeFoods())?></span>
                                        </div>
                                    </div>

                                    <div class="section-catalog__wrapper-card-price flex-shrink-0 d-flex align-items-center">
                                        <div class="section-catalog__price__wrapper w-100">
                                            <div
                                                class="section-catalog__wrapper-for-day d-flex gap-3 align-items-end align-items-lg-start flex-lg-column">
                                                <div class="section-catalog__price">от 4 200 руб.</div>
                                                <div class="section-catalog__for-number">за номер в сутки</div>
                                            </div>
                                            <a class="btn btn-outline-secondary" href="/Catalog/Objects/<?php print (int)$catalog_object->getObjectId();?>/About">Подробнее</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>


                    </ul>
                    <!-- <div class="section-catalog__show-more">
                        <a class="btn btn-warning" href="#">Показать еще 20</a>
                    </div> -->
                </div>
            </div>

        </div>


        <?php
    }

}