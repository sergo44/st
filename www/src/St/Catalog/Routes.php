<?php

namespace St\Catalog;

use St\ApplicationError;
use St\CatalogObjectType;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\Catalog;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Layouts;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизатор каталога
     * @throws HttpError403Exception
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#^/?Catalog/Objects/Add/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\AddObjectController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\AddObject\AddObjectHtmlView()))->index();
        }

        if (preg_match("#^/?Catalog/Objects/Add/Go/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\AddObjectController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\AddObject\AddObjectHtmlView()))->addGo();
        }

        if (preg_match("#^/?Catalog/ListObjects/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ListObjectsController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\ListObjects\ListObjectsHtmlView()))->index();
        }


        if (preg_match("#^/?Catalog/Objects/Hotels/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ShowObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(CatalogObjectType::Hotel);
        }

        if (preg_match("#^/?Catalog/Objects/Guest_House/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ShowObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(CatalogObjectType::Guest_House);
        }

        if (preg_match("#^/?Catalog/Objects/Hostel/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ShowObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(CatalogObjectType::Hostel);
        }

        if (preg_match("#^/?Catalog/Objects/Apartment/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ShowObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(CatalogObjectType::Apartment);
        }

        if (preg_match("#^/?Catalog/Objects/Camping/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ShowObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(CatalogObjectType::Camping);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9]+[0-9]*)/About/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\AboutObjectController($_REQUEST, new Layouts\Site\AboutObjectHtmlLayout(), new Catalog\Views\AboutObject\AboutObjectHtmlView()))->index($match[1]);
        }

        if (preg_match("#^/?Catalog/Map/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ObjectsMapController($_REQUEST, new Layouts\Site\ContentHtmlLayout(), new Catalog\Views\ObjectsMap\ObjectsMapHtmlView()))->index();
        }

        return null;
    }
}