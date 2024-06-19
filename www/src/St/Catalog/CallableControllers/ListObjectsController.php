<?php

namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\GetUserCatalogObjects;
use St\Catalog\Views\ListObjects\ListObjectsHtmlView;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Views\IView;

class ListObjectsController extends UserCallableController implements ICallableController
{
    /**
     * Возвращает вид (для IDE)
     * @return ListObjectsHtmlView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер вывода списка моих объявлений
     * @return ICallableController
     * @throws ApplicationError
     */
    public function index(): ICallableController
    {

        $this->getView()
            ->setCatalogObjects( (new GetUserCatalogObjects($this->getUser()->getUserId()))->getCatalogObjects() )
        ;

        return $this;
    }

}