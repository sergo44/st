<?php

namespace St\Catalog\Views\ManageObjects;

use St\CatalogObject;

interface IManageObjectsView
{
    /**
     * Устанавливает object
     * @param CatalogObject|null $object
     * @return IManageObjectsView
     * @see object
     */
    public function setObject(?CatalogObject $object): IManageObjectsView;
}