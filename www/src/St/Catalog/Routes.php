<?php

namespace St\Catalog;

use St\ApplicationError;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\Catalog;
use St\HttpError403Exception;
use St\Layouts;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизатор каталога
     * @throws HttpError403Exception
     * @throws ApplicationError
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#^/?Catalog/Objects/Add/?$#ui", $this->dispatcher->getPath())) {
            return (new Catalog\CallableControllers\AddObjectController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new Catalog\Views\AddObject\AddObjectHtmlView()))->index();
        }

        return null;
    }
}