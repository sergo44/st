<?php

namespace St\User;

use St\ApplicationError;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\HttpError403Exception;
use St\Layouts;
use St\User;

class Routes extends FileRoute implements IRoute
{

    /**
     * Пробуем пройти маршруты
     * @throws ApplicationError
     * @throws HttpError403Exception
     */
    #[\Override] public function tryRoute(): null|ICallableController
    {
        if (preg_match("#^/?User/Register/?$#ui", $this->dispatcher->getPath())) {
            /** @todo */
            return (new User\CallableControllers\UserRegisterController($_REQUEST, new Layouts\Site\IndexHtmlLayout(), new User\Views\UserRegister\UserRegisterHtmlView()))->index();
        }

        if (preg_match("#^/?Api/User/Register/Go/?$#ui", $this->dispatcher->getPath())) {
            return (new User\CallableControllers\UserRegisterGoController($_REQUEST, new Layouts\JsonLayout(), new User\Views\UserRegister\UserRegisterGoJsonView()))->index();
        }

        if (preg_match("#^/?Api/User/SignIn/Go/?$#ui", $this->dispatcher->getPath())) {
            return (new User\CallableControllers\UserSignInGoController($_REQUEST, new Layouts\JsonLayout(), new Views\Sign\UserSignInGoJsonView()))->signInGo();
        }

        if (preg_match("#^/?User/Account/?$#ui", $this->dispatcher->getPath())) {
            /** @todo */
            return (new User\CallableControllers\UserAccountController($_REQUEST, new Layouts\Site\UserHtmlLayout(), new User\Views\Account\AccountIndexHtmlView()))->index();
        }

        return null;
    }
}