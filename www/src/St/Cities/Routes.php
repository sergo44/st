<?php

namespace St\Cities;

use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\Cities;
use St\Layouts;

class Routes extends FileRoute implements IRoute
{

    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#/?Api/Cities/Get/([0-9]+)/?#u", $this->dispatcher->getPath(), $match)) {
            return (new Cities\CallableControllers\GetCitiesController(array("region_id" => $match[1]), new Layouts\JsonLayout(), new Cities\Views\GetCitiesJsonView()))->index();
        }

        return null;
    }
}