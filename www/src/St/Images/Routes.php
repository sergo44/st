<?php

namespace St\Images;

use St\ApplicationError;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Images;
use St\Layouts;
use St\Views\Common\ResultJsonView;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизация контроллера
     * @throws HttpError404Exception
     * @throws HttpError403Exception
     * @throws ApplicationError
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#/?Images/Upload/([a-zA-Z]+)/?#u", $this->dispatcher->getPath(), $match)) {
            return (new Images\CallableControllers\UploadImageController(
                $_FILES,
                new Layouts\JsonLayout(),
                new Images\Views\UploadImageResultJsonView())
            )->index($match[1]);
        }

        if (preg_match("#/?Images/RemoveJustUploaded/?#u", $this->dispatcher->getPath(), $match)) {
            return (new Images\CallableControllers\RemoveJustUploadedController(
                $_POST,
                new Layouts\JsonLayout(),
                new ResultJsonView()
            ))->index();
        }

        return null;
    }
}