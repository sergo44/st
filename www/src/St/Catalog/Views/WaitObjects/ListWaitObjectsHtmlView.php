<?php

namespace St\Catalog\Views\WaitObjects;

use St\CatalogObject;
use St\Views\HtmlView;
use St\Views\IView;

class ListWaitObjectsHtmlView extends HtmlView implements IView
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
     * @return ListWaitObjectsHtmlView
     * @see catalog_objects
     */
    public function setCatalogObjects(array $catalog_objects): ListWaitObjectsHtmlView
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
        <?php if (sizeof($this->getCatalogObjects())):?>
        <ul class="section-ads__list " id="waitObjectsList">

            <?php foreach ($this->getCatalogObjects() as $catalog_object):?>

                <li class="mt-4">
                    <div class="section-ads__wrapper-item d-flex gap-4 align-items-center justify-content-between">
                        <div class="section-ads__wrapper-left d-flex gap-4 align-items-center">
                            <div class="section-ads__wrapper-photo">
                                <img alt="" src="<?php print $catalog_object->getFirstImage() ? $catalog_object->getFirstImage()->getUri(142, 142, true) : "/images/no-image.svg";?>" style="width: 142px">
                            </div>
                            <div class="section-ads__wrapper-description">
                                <h5 class="section-catalog__card-title"><?php print $this->escape($catalog_object->getName())?></h5>
                                <div class="section-catalog__card-advantages d-flex align-items-center gap-3 mt-2">
                                    <span><?php print $this->escape($catalog_object->getAddressLines());?></span>
                                </div>
                                <div class="d-flex section-catalog__card-advantages gap-3">
                                    Дата публикации (редактирования): <?php print $catalog_object->getLastModifiedDatetimeAsObject()->format("d.m.Y H:i"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex mt-2 justify-content-end">
                        <ul class="list-inline">
                            <li class="list-inline-item"><a class="d-block mb-2" href="/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/Approve" data-ajax-url="/Api/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/Approve" data-manage-object="1">Допустить публикацию</a></li>
                            | <li class="list-inline-item"><a class="d-block mb-2" href="/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/Decline" data-ajax-url="/Api/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/Decline" data-manage-object="1">Отклонить публикацию</a></li>
                            | <li class="list-inline-item"><a class="d-block mb-2" href="/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/Edit">Редактировать</a></li>
                            | <li class="list-inline-item"><a class="d-block mb-2" href="/Catalog/Objects/<?php print $catalog_object->getObjectId();?>/About">Подробнее</a></li>
                        </ul>
                    </div>
                </li>

            <?php endforeach; ?>

        </ul>
        <?php else: ?>
        <div class="d-flex w-100 justify-content-start">Объекты, ожидающие модерацию не найдены</div>
        <?php endif; ?>



        <?php
    }
}