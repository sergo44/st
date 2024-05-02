<?php

namespace St\Regions\Views;

use St\Region;

interface IGetRegionsView
{
    /**
     * Устанавливает regions
     * @param array $regions
     * @return GetRegionsJsonView
     * @see regions
     */
    public function setRegions(array $regions): IGetRegionsView;
}