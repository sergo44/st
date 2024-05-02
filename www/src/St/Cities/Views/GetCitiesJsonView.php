<?php

namespace St\Cities\Views;

use St\City;
use St\Views\IView;
use St\Views\JsonView;

class GetCitiesJsonView extends JsonView implements IView, \JsonSerializable, IGetCitiesView
{
    /**
     * Города для отображения
     * @var City[]
     */
    protected array $cities = array();

    /**
     * Возвращает cities
     * @return array
     * @see cities
     */
    public function getCities(): array
    {
        return $this->cities;
    }

    /**
     * Устанавливает cities
     * @param array $cities
     * @return GetCitiesJsonView
     * @see cities
     */
    public function setCities(array $cities): GetCitiesJsonView
    {
        $this->cities = $cities;
        return $this;
    }


    /**
     * Выполняет отображение
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->cities;
    }
}