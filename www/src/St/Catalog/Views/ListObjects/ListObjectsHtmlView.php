<?php

namespace St\Catalog\Views\ListObjects;

use St\CatalogObject;
use St\Views\HtmlView;
use St\Views\IView;

class ListObjectsHtmlView extends HtmlView implements IView
{
    /**
     * Объекты для вывода
     * @var CatalogObject[]
     */
    protected array $catalog_objects = array();

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
     * @return ListObjectsHtmlView
     * @see catalog_objects
     */
    public function setCatalogObjects(array $catalog_objects): ListObjectsHtmlView
    {
        $this->catalog_objects = $catalog_objects;
        return $this;
    }

    /**
     * @inheritDoc
     * @return void
     */
    public function out(): void
    {
        ?>
        <h1 class="d-flex align-items-center justify-content-between">Мои объявления<a
                class="btn btn-warning d-flex gap-2 mt-0" href="/Catalog/Objects/Add/"
                style="padding-left: 2rem;padding-right: 2rem;">
                <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.125 10H16.875" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10 3.125V16.875" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Добавить объявление</a></h1>
         <!-- <div class=" attention-block attention-error position-relative mt-5 mb-5">
            <div class="attention-title-block d-flex align-items-center justify-content-between">
                <div class="attention-title d-flex align-items-center gap-2">
                    <div class="wrapper-attention-icon">
                        <img alt="" src="/images/icons/attention-error.svg">
                    </div>
                    ВНИМАНИЕ
                </div>
                <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal"
                        type="button"></button>
            </div>
            <div class="section-profile__confirm-email ps-4 mt-3">Карточка объявления Отель “Маяк” отклонена. Указанная
                вами информация не соответствует действителности. Фото не относятся к объекту.
            </div>
        </div>
        <div class="hidden attention-block attention-success position-relative mt-5 mb-5">
            <div class="attention-title-block d-flex align-items-center justify-content-between">
                <div class="attention-title d-flex align-items-center gap-2">
                    <div class="wrapper-attention-icon">
                        <img alt="" src="/images/icons/attention-success.svg">
                    </div>
                    УСПЕШНО
                </div>
                <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal" type="button"></button>
            </div>
            <div class="section-profile__confirm-email ps-4 mt-3">Карточка объекта Отель “Маяк” создана и направлена на
                проверку.
            </div>
        </div> -->


        <ul class="section-ads__list">

            <?php foreach ($this->getCatalogObjects() as $catalog_object):?>

            <li class="mt-4">
                <div class="section-ads__wrapper-item d-flex gap-4 align-items-center justify-content-between ">
                    <div class="section-ads__wrapper-left d-flex gap-4 align-items-center">
                        <div class="section-ads__wrapper-photo">
                            <img alt="" src="<?php print $catalog_object->getFirstImage() ? $catalog_object->getFirstImage()->getUri(142, 142, true) : "/images/no-image.svg";?>" style="width: 142px">
                        </div>
                        <div class="section-ads__wrapper-description">
                            <h5 class="section-catalog__card-title"><?php print $this->escape($catalog_object->getName())?></h5>
                            <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                                <span><?php print $this->escape($catalog_object->getAddressLines());?></span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                        <span>7 номеров</span>
                    </div> -->
                    <div class="section-ads__status added">
                        <!-- Добавлено -->
                    </div>
                    <div class="section-ads__three-dots d-flex align-items-center justify-content-center position-relative">

                        <ul class="section-ads__edit position-absolute">
                            <li><a class="d-block mb-2" href="/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/Edit">Редактировать</a></li>
                            <li><a class="ads-remove" href="#">Удалить</a></li>
                        </ul>
                        <svg fill="none" height="2.8rem" viewBox="0 0 28 28" width="2.8rem"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                    d="M14 15.3125C14.7249 15.3125 15.3125 14.7249 15.3125 14C15.3125 13.2751 14.7249 12.6875 14 12.6875C13.2751 12.6875 12.6875 13.2751 12.6875 14C12.6875 14.7249 13.2751 15.3125 14 15.3125Z"
                                    fill="#F97800"/>
                            <path
                                    d="M14 8.3125C14.7249 8.3125 15.3125 7.72487 15.3125 7C15.3125 6.27513 14.7249 5.6875 14 5.6875C13.2751 5.6875 12.6875 6.27513 12.6875 7C12.6875 7.72487 13.2751 8.3125 14 8.3125Z"
                                    fill="#F97800"/>
                            <path
                                    d="M14 22.3125C14.7249 22.3125 15.3125 21.7249 15.3125 21C15.3125 20.2751 14.7249 19.6875 14 19.6875C13.2751 19.6875 12.6875 20.2751 12.6875 21C12.6875 21.7249 13.2751 22.3125 14 22.3125Z"
                                    fill="#F97800"/>
                        </svg>
                    </div>
                </div>

            </li>

            <?php endforeach; ?>

        </ul>

        <?php
    }
}