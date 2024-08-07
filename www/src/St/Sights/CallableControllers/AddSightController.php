<?php

namespace St\Sights\CallableControllers;

use Override;
use St\ApplicationError;
use St\Countries\GetVisibleCountries;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\Sights\Views\AddSight\AddSightHtmlView;
use St\Views\IView;

class AddSightController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return AddSightHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер добавления достопримечательности
     * @return $this
     * @throws ApplicationError
     */
    public function index(): AddSightController
    {
        $this->getView()
            ->setResult( $result = new Result() )
            ->setCountriesList( (new GetVisibleCountries())->getCountries() )
            ;

        $this->getLayout()
            ->setSectionTitle("Достопримечательности")
            ->addJs("/build/add_sight.bundle.js")
        ;

        return $this;
    }
}