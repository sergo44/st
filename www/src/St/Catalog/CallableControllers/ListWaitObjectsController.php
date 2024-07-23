<?php

namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\GetWaitCatalogObjects;
use St\Catalog\Views\WaitObjects\ListWaitObjectsHtmlView;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\Result;
use St\Views\IView;

class ListWaitObjectsController extends UserCallableController implements ICallableController
{
    /**
     * Возвращает вид
     * @return ListWaitObjectsHtmlView
     */
    public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер отображения объектов
     * @return ListWaitObjectsController
     * @throws ApplicationError
     * @throws HttpError403Exception
     */
    public function index(): ListWaitObjectsController
    {
        try {

            $this->getView()
                ->setResult( $result = new Result() )
            ;

            $this->getLayout()
                ->setSectionTitle("Проверка объектов")
                ->addJs("/build/manage_wait_objects.bundle.js")
            ;

            if (!$this->getUser()->getUserRoleHelper()->canModerationObjects()) {
                throw new HttpError403Exception(sprintf("У вас нет доступа к разделу управления ожидающих объектов (user_id %u", $this->getUser()->getUserId()));
            }

            $objects = (new GetWaitCatalogObjects())->getObjects();
            $this->getView()->setCatalogObjects( $objects );

        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }
}