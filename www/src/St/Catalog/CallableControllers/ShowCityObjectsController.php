<?php

namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\GetObjectsByCity;
use St\Catalog\GetWaitCatalogObjects;
use St\Catalog\Views\ShowObjects\ShowObjectsHtmlView;
use St\CatalogObject;
use St\City;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\HttpError404Exception;
use St\Views\IView;

class ShowCityObjectsController extends CallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return ShowObjectsHtmlView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер отображения
     * @return $this
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    public function index(int $city_id): ShowCityObjectsController
    {
        $city = City::get($city_id);

        if (!$city->getCityId()) {
            throw new HttpError404Exception(sprintf("Город с идентификатором %u не найден", $city_id));
        }

        $this->getView()
            ->setCatalogObjects( (new GetObjectsByCity($city))->getObjects() );

        $this->getLayout()
            ->setSectionTitle(sprintf("Размещение в \"%s\"", $city->getName()))
            ;

        return $this;
    }
}