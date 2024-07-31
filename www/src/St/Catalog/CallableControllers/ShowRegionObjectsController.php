<?php

namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\BreadCrumbs;
use St\BreadCrumbsItem;
use St\Catalog\GetObjectsByRegion;
use St\Catalog\Views\ShowObjects\ShowObjectsHtmlView;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\HttpError404Exception;
use St\Region;
use St\Views\IView;

class ShowRegionObjectsController extends CallableController implements ICallableController
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
     * Контроллер вывода
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    public function index(int $region_id): ShowRegionObjectsController
    {

        $region = Region::get($region_id);
        if (!$region->getRegionId()) {
            throw new HttpError404Exception(sprintf("Регион с идентификатором %u не найден", $region_id));
        }

        BreadCrumbs::getInstance()->add( new BreadCrumbsItem($region->getName(), $region->getBreadcrumbsUrl()) );

        $this->getView()
            ->setCatalogObjects( (new GetObjectsByRegion($region))->getObjects() )
            ;

        $this->getLayout()
            ->setSectionTitle(sprintf("Размещение в %s", $region->getName()))
            ;

        return $this;
    }
}