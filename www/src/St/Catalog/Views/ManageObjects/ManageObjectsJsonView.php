<?php

namespace St\Catalog\Views\ManageObjects;

use St\CatalogObject;
use St\Views\IView;
use St\Views\JsonView;

class ManageObjectsJsonView extends JsonView implements \JsonSerializable, IView, IManageObjectsView
{
    /**
     * Catalog objects
     * @var CatalogObject|null
     */
    protected ?CatalogObject $object = null;

    /**
     * Устанавливает object
     * @param CatalogObject|null $object
     * @return ManageObjectsJsonView
     * @see object
     */
    public function setObject(?CatalogObject $object): ManageObjectsJsonView
    {
        $this->object = $object;
        return $this;
    }

    /**
     * @inheritdoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult(),
            "object" => $this->object
        );
    }
}