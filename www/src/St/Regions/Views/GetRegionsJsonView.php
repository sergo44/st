<?php

namespace St\Regions\Views;

use St\Region;
use St\Views\IView;
use St\Views\JsonView;

class GetRegionsJsonView extends JsonView implements IView, \JsonSerializable, IGetRegionsView
{
    /**
     * Регионы для отображения
     * @var Region[]
     */
    protected array $regions = array();

    /**
     * Метод используется для сериализации данных
     * @return Region[]
     */
    public function jsonSerialize(): array
    {
        return $this->regions;
    }

    /**
     * Устанавливает regions
     * @param array $regions
     * @return GetRegionsJsonView
     * @see regions
     */
    public function setRegions(array $regions): GetRegionsJsonView
    {
        $this->regions = $regions;
        return $this;
    }




}