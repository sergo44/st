<?php

namespace St\Sights\Views;

use Override;
use St\Sights\Sight;
use St\Views\HtmlView;
use St\Views\IView;

class ListSightsHtmlView extends HtmlView implements IView
{
    /**
     * Список достопримечательностей для отображения
     * @var Sight[]
     */
    protected array $sights = array();

    /**
     * Возвращает sights
     * @return array
     * @see sights
     */
    public function getSights(): array
    {
        return $this->sights;
    }

    /**
     * Устанавливает sights
     * @param array $sights
     * @return ListSightsHtmlView
     * @see sights
     */
    public function setSights(array $sights): ListSightsHtmlView
    {
        $this->sights = $sights;
        return $this;
    }

    #[Override] public function out(): void
    {
        ?>

        <div class="d-flex col-sm-4 justify-content-end w-100">
            <a
                class="btn btn-warning d-flex gap-2 mt-0" href="/Sights/Add"
                style="padding-left: 2rem;padding-right: 2rem;">
                <svg fill="none" height="2rem" viewBox="0 0 20 20" width="2rem" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.125 10H16.875" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10 3.125V16.875" stroke="#ffffff" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                Добавить достопримечательность</a>
        </div>

        <ul class="section-ads__list">

            <?php foreach ($this->getSights() as $sight):?>

                <li class="mt-4">
                    <div class="section-ads__wrapper-item d-flex gap-4 align-items-center justify-content-between ">
                        <div class="section-ads__wrapper-left d-flex gap-4 align-items-center">
                            <div class="section-ads__wrapper-photo">
                                <img alt="" src="<?php print $sight->getMainImage() ? "/" . $sight->getMainImage()->getUri(142, 142, true) : "/images/no-image.svg";?>" style="width: 142px">
                            </div>
                            <div class="section-ads__wrapper-description">
                                <h5 class="section-catalog__card-title"><?php print $this->escape($sight->getName())?></h5>
                                <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                                    <span><?php print $this->escape($sight->getDescription());?></span>
                                </div>
                            </div>
                        </div>
                        <div class="section-ads__status">
                            <?php print $sight->getStatusEnum()->label()?>
                        </div>
                        <div class="section-ads__three-dots d-flex align-items-center justify-content-center position-relative">

                            <ul class="section-ads__edit position-absolute">
                                <li><a class="d-block mb-2" href="/Sights/<?php print $sight->getSightId();?>/Edit">Редактировать</a></li>
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