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

        if (preg_match("#^/?Catalog/Objects/([1-9][0-9]*)/Edit/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\EditObjectController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\EditObject\EditObjectHtmlView()))->index($match[1]);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9][0-9]*)/Edit/([1-9][0-9]*)/PurgeImage/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\PurgeObjectImageController($_REQUEST, new Layouts\JsonLayout(), new Catalog\Views\EditObject\PurgeImageJsonView()))->index((int)$match[1], (int)$match[2]);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9][0-9]*)/Edit/([1-9][0-9]*)/RemoveRoom/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\RemoveRoomController($_REQUEST, new Layouts\JsonLayout(), new Catalog\Views\EditObject\RemoveRoomJsonView()))->index((int)$match[1], (int)$match[2]);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9][0-9]*)/Edit/Go/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\EditObjectController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\EditObject\EditObjectHtmlView()))->editGo($match[1]);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9][0-9]*)/Approve/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ManageObjectsController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\ManageObjects\ManageObjectsHtmlView()))->approve($match[1]);
        }

        if (preg_match("#^/?Api/Catalog/Objects/([1-9][0-9]*)/Approve/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ManageObjectsController($_REQUEST, new Layouts\JsonLayout(), new Catalog\Views\ManageObjects\ManageObjectsJsonView()))->approve($match[1]);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9][0-9]*)/Decline/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ManageObjectsController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\ManageObjects\ManageObjectsHtmlView()))->approve($match[1]);
        }

        if (preg_match("#^/?Api/Catalog/Objects/([1-9][0-9]*)/Decline/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ManageObjectsController($_REQUEST, new Layouts\JsonLayout(), new Catalog\Views\ManageObjects\ManageObjectsJsonView()))->approve($match[1]);
        }

        if (preg_match("#^/?Catalog/Objects/Hotels/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ShowObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(CatalogObjectType::Hotel);
        }

        if (preg_match("#^/?Catalog/Objects/Wait/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ListWaitObjectsController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\WaitObjects\ListWaitObjectsHtmlView()))->index();
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

        if (preg_match("#^/?Catalog/Objects/Irkutsk/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowRegionObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(1);
        }

        if (preg_match("#^/?Catalog/Objects/Buryatia/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowRegionObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(2);
        }

        if (preg_match("#^/?Catalog/Objects/Buryatia/WarmLake/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowCityObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(6);
        }

        if (preg_match("#^/?Catalog/Objects/Buryatia/Goryachinsk/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowCityObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(4);
        }

        if (preg_match("#^/?Catalog/Objects/Buryatia/Arshan/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowCityObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(5);
        }

        if (preg_match("#^/?Catalog/Objects/Irkutsk/Olkhon/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowCityObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(3);
        }

        if (preg_match("#^/?Catalog/Objects/Irkutsk/Listvyanka/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowCityObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index(2);
        }


        if (preg_match("#^/?Catalog/Objects/City/([1-9][0-9]*)/List/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\ShowCityObjectsController($_REQUEST, new Layouts\Site\CatalogHtmlLayout(), new Catalog\Views\ShowObjects\ShowObjectsHtmlView()))->index($match[1]);
        }

        if (preg_match("#^/?Catalog/Objects/([1-9]+[0-9]*)/About/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Catalog\CallableControllers\AboutObjectController($_REQUEST, new Layouts\Site\AboutObjectHtmlLayout(), new Catalog\Views\AboutObject\AboutObjectHtmlView()))->index($match[1]);
        }

        if (preg_match("#^/?Catalog/Map/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\ObjectsMapController($_REQUEST, new Layouts\Site\ContentHtmlLayout(), new Catalog\Views\ObjectsMap\ObjectsMapHtmlView()))->index();
        }

        if (preg_match("#^/?Catalog/Objects/Add/AddHotelRoom/Go/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\AddHotelRoomController($_REQUEST, new Layouts\JsonLayout(), new Catalog\Views\HotelRooms\AddHotelRoomGoJsonView()))->index();
        }

        if (preg_match("#^/?Catalog/Objects/Room/Book/Go/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\OrderHotelRoomController($_REQUEST, new Layouts\JsonLayout(), new Catalog\Views\AboutObject\OrderHotelRoomJsonView()))->index();
        }

        return null;
    }
}