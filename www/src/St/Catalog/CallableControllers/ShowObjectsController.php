<?php

namespace St\Catalog\CallableControllers;

use St\Catalog\GetObjectsByType;
use St\Catalog\Views\ShowObjects\ShowObjectsHtmlView;
use St\CatalogObjectType;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\Views\IView;

class ShowObjectsController extends CallableController implements ICallableController
{
    /**
     * Возвращает вид (для IDE)
     * @return ShowObjectsHtmlView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер вывода объектов
     * @param CatalogObjectType $object_type
     * @return ICallableController
     */
    public function index(CatalogObjectType $object_type): ICallableController
    {

        $this->getLayout()
            ->setSectionTitle("Поиск проживания")
        ;

        $this->getView()
            ->setCatalogObjects( (new GetObjectsByType($object_type))->getCatalogObjects() )
        ;

        return $this;
    }
}