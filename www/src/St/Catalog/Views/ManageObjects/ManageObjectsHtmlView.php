<?php

namespace St\Catalog\Views\ManageObjects;

use St\CatalogObject;
use St\Views\HtmlView;
use St\Views\IView;

class ManageObjectsHtmlView extends HtmlView implements IManageObjectsView, IView
{
    /**
     * Объект каталога
     * @var CatalogObject|null
     */
    protected ?CatalogObject $object = null;

    /**
     * Устанавливает object
     * @param CatalogObject|null $object
     * @return ManageObjectsHtmlView
     * @see object
     */
    public function setObject(?CatalogObject $object): ManageObjectsHtmlView
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @inheritdoc
     * @return void
     */
    #[\Override] public function out(): void
    {
        ?>

        <?php if ($this->getResult()->isSuccess()):?>
        <div class="alert alert-success">
            <h4>Успешно</h4>
            <div>Объект <?php print $this->escape($this->object?->getName())?> успешно <?php print $this->object->getStatusAsEnum()->getActionLabel()?></div>
            <div><a href="/Catalog/Objects/Wait">Вернуться к списку ожидающих объектов</a></div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            <h4>Ошибка</h4>
            <div><ul><li><?php print $this->getResult()->getErrorsAsString();?></li></ul></div>
            <div><a href="/Catalog/Objects/Wait">Вернуться к списку ожидающих объектов</a></div>
        </div>
        <?php endif; ?>


        <?php
    }


}