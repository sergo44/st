<?php

namespace St\Sights\Views\WaitSights;

use Override;
use St\ApplicationError;
use St\Sights\Sight;
use St\Views\HtmlView;
use St\Views\IView;

class ListWaitSightsHtmlView extends HtmlView implements IView
{
    /**
     * Объекты для отображения
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
     * @return ListWaitSightsHtmlView
     * @see sights
     */
    public function setSights(array $sights): ListWaitSightsHtmlView
    {
        $this->sights = $sights;
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

        <?php if (sizeof($this->getSights())):?>
            <ul class="section-ads__list " id="waitObjectsList">

                <?php foreach ($this->getSights() as $sight):?>

                    <li class="mt-4">
                        <div class="section-ads__wrapper-item d-flex gap-4 align-items-center justify-content-between">
                            <div class="section-ads__wrapper-left d-flex gap-4 align-items-center">
                                <div class="section-ads__wrapper-photo">
                                    <img alt="" src="/<?php print $sight->getMainImage() ? $sight->getMainImage()->getUri(142, 142, true) : "images/no-image.svg";?>" style="width: 142px">
                                </div>
                                <div class="section-ads__wrapper-description">
                                    <h5 class="section-catalog__card-title"><?php print $this->escape($sight->getName())?></h5>
                                    <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                                        <span><?php print $this->escape(mb_substr(strip_tags($sight->getDescription()), 0, 150));?></span>
                                    </div>
                                    <div class="d-flex section-catalog__card-advantages gap-3">
                                        Дата публикации (редактирования): <?php print $sight->getCreatedDatetimeUtc(true)->format("d.m.Y H:i"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex mt-2 justify-content-end">
                            <ul class="list-inline">
                                <li class="list-inline-item"><a class="d-block mb-2" href="/Sights/Wait/<?php print $sight->getSightId();?>/Approve" data-ajax-url="/Sights/Wait/<?php print $sight->getSightId();?>/Approve" data-manage-object="1">Допустить публикацию</a></li>
                                | <li class="list-inline-item"><a class="d-block mb-2" href="/Sights/Wait/<?php print $sight->getSightId();?>/Decline" data-ajax-url="/Sights/Wait/<?php print $sight->getSightId();?>/Decline" data-manage-object="1">Отклонить публикацию</a></li>
                                | <li class="list-inline-item"><a class="d-block mb-2" href="/Sights/<?php print $sight->getSightId();?>/Edit">Редактировать</a></li>
                                | <li class="list-inline-item"><a class="d-block mb-2" href="/Sights/<?php print $sight->getSightId();?>/About">Подробнее</a></li>
                            </ul>
                        </div>
                    </li>

                <?php endforeach; ?>

            </ul>
        <?php else: ?>
            <div class="d-flex w-100 justify-content-start">Достопримечательности, ожидающие модерацию не найдены</div>
        <?php endif; ?>

        <?php
    }

}