<?php

namespace St\Regions\CallableControllers;

use Override;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\Regions\GetCountryRegions;
use St\Regions\Views\IGetRegionsView;
use St\Views\IView;

class GetRegionsController extends CallableController implements ICallableController
{
    /**
     * Get View
     * @return IGetRegionsView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер получения регионов
     * @return $this
     */
    public function index(): GetRegionsController
    {
        $this->getView()->setRegions( (new GetCountryRegions((int)$this->getUserInputData("country_id")))->getRegions() );
        return $this;
    }
}