<?php

namespace St\Sights;

use St\ApplicationError;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\HttpError403Exception;
use St\Layouts\Site\UserHtmlLayout;
use St\Sights;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизация для "Достопримечательностей"
     * @throws HttpError403Exception
     * @throws ApplicationError
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {

        if (preg_match("#^/?Sights/Add/?$#", $this->dispatcher->getPath())) {
            return (new Sights\CallableControllers\AddSightController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\AddSight\AddSightHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/Add/Go/?$#", $this->dispatcher->getPath())) {
            return (new Sights\CallableControllers\AddSightGoController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\AddSight\AddSightGoHtmlView()
            ))->index();
        }

        if (preg_match("#^/?Sights/List/?$#", $this->dispatcher->getPath())) {
            return (new Sights\CallableControllers\ListSightsController(
                $_REQUEST,
                new UserHtmlLayout(),
                new Sights\Views\ListSightsHtmlView()
            ))->index();
        }

        return null;
    }
}