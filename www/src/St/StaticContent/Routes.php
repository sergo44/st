<?php

namespace St\StaticContent;

use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\Layouts;
use St\StaticContent;

class Routes extends FileRoute implements IRoute
{

    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#^/?StaticContent/Index/?$#ui", $this->dispatcher->getPath())) {
            return (new StaticContent\CallableControllers\StaticContentController($_REQUEST, new Layouts\Site\IndexHtmlLayout(), new StaticContent\Views\Index\IndexContentHtmlView()))->index();
        }

        return null;
    }
}