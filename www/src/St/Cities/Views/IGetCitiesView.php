<?php

namespace St\Cities\Views;

use St\City;

interface IGetCitiesView
{
    /**
     * Устанавливает cities
     * @param City[] $cities
     * @return GetCitiesJsonView
     * @see cities
     */
    public function setCities(array $cities): IGetCitiesView;
}