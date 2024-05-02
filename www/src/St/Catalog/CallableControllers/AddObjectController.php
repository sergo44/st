<?php

namespace St\Catalog\CallableControllers;

use St\Catalog\Views\AddObject\AddObjectHtmlView;
use St\CatalogObject;
use St\Countries\GetVisibleCountries;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Views\IView;

class AddObjectController extends UserCallableController implements ICallableController
{
    /**
     * Указывает какой шаблон, который возвращается контроллером
     * @return AddObjectHtmlView|IView
     */
    #[\Override] public function getView(): AddObjectHtmlView|IView
    {
        return parent::getView();
    }

    /**
     * Контролер отображения формы добавления объекта
     * @return ICallableController
     */
    public function index(): ICallableController
    {
        $this->getLayout()
            ->setSectionTitle("Добавление объекта")
        ;

        $this->getView()
            ->setCountriesList((new GetVisibleCountries())->getCountries())
            ->setCatalogObject(new CatalogObject())
        ;

        return $this;
    }
}