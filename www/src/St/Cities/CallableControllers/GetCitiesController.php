<?php

namespace St\Cities\CallableControllers;

use Override;
use St\Cities\GetRegionCities;
use St\Cities\Views\IGetCitiesView;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\Views\IView;

class GetCitiesController extends CallableController implements ICallableController
{
    /**
     * Возвращает вид (используется для обозначения ожидаемого типа)
     * @return IGetCitiesView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер получения населенных пунктов
     * @return $this
     */
    public function index(): GetCitiesController
    {
        $this->getView()->setCities( (new GetRegionCities((int)$this->getUserInputData("region_id")))->getCities() );
        return $this;
    }

}