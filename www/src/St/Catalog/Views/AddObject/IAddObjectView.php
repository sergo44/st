<?php

namespace St\Catalog\Views\AddObject;

use St\CatalogObject;
use St\Country;

interface IAddObjectView
{
    /**
     * Устанавливает catalog_object
     * @param CatalogObject $catalog_object
     * @return AddObjectHtmlView
     * @see catalog_object
     */
    public function setCatalogObject(CatalogObject $catalog_object): IAddObjectView;

    /**
     * Список стран для отображения в списке для выбора
     * @param Country[] $countries_list
     * @return IAddObjectView
     */
    public function setCountriesList(array $countries_list): IAddObjectView;
}