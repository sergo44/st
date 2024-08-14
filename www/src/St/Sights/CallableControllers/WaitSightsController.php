<?php

namespace St\Sights\CallableControllers;

use Override;
use St\ApplicationError;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\Result;
use St\Sights\GetWaitSights;
use St\Sights\Views\WaitSights\ListWaitSightsHtmlView;
use St\Views\IView;

class WaitSightsController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return ListWaitSightsHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер вывода списка ожидающих достопримечательностей
     * @return WaitSightsController
     * @throws ApplicationError
     * @throws HttpError403Exception
     */
    public function index(): WaitSightsController
    {

        try {

            $this->getView()
                ->setResult( $result = new Result() )
            ;

            $this->getLayout()
                ->setSectionTitle("Достопримечательности, ожидающие проверки")
                // ->addJs("/build/manage_wait_objects.bundle.js")
            ;

            if (!$this->getUser()->getUserRoleHelper()->canModerationObjects()) {
                throw new HttpError403Exception(sprintf("У вас нет доступа к разделу управления ожидающих объектов (user_id %u)", $this->getUser()->getUserId()));
            }

            $sights = (new GetWaitSights())->getSights();

            $this->getView()->setSights( $sights );

        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }
}