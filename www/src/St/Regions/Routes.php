<?php

namespace St\Regions;

use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\Regions;
use St\Layouts;

class Routes extends FileRoute implements IRoute
{

    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#^/?Api/Regions/Get/([0-9]+)/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Regions\CallableControllers\GetRegionsController(array("country_id" => $match[1]), new Layouts\JsonLayout(), new Regions\Views\GetRegionsJsonView()))->index();
        }

        return null;
    }
}