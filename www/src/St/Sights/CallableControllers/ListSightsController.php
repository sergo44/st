<?php

namespace St\Sights\CallableControllers;

use Override;
use St\ApplicationError;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\Sights\GetSightByUserId;
use St\Sights\Views\ListSightsHtmlView;
use St\Views\IView;

class ListSightsController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return ListSightsHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер вывода достопримечательностей
     * @return $this
     * @throws ApplicationError
     */
    public function index(): ListSightsController
    {
        $this->getView()
            ->setResult( $result = new Result() )
            ->setSights( (new GetSightByUserId($this->getUser()->getUserId()))->getSights() )
        ;

        $this->getLayout()
            ->setSectionTitle("Мои достопримечательности")
        ;

        return $this;
    }
}