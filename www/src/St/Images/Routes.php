<?php

namespace St\Images;

use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\HttpError404Exception;
use St\Images;
use St\Layouts;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизация контроллера
     * @throws HttpError404Exception
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#/?Images/Upload/([a-zA-Z]+)/?#u", $this->dispatcher->getPath(), $match)) {
            return (new Images\CallableControllers\UploadImageController($_FILES, new Layouts\JsonLayout(), new Images\Views\UploadImageResultJsonView()))->index($match[1]);
        }

        return null;
    }
}