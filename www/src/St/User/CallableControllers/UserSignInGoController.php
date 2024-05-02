<?php

namespace St\User\CallableControllers;

use St\ApplicationError;
use St\Auth;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\Result;
use St\User\FindUserByLogin;
use St\User\Views\Sign\UserSignInGoJsonView;
use St\Views\IView;

class UserSignInGoController  extends CallableController implements ICallableController
{
    /**
     * Возвращает текущий вид (для IDE)
     * @return UserSignInGoJsonView
     */
    public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер отображения страницы входа
     * @return $this
     */
    public function index(): UserSignInGoController
    {
        /** @todo No sign in page yet */
        return $this;
    }

    /**
     * Контроллер входа
     * @throws ApplicationError
     */
    public function signInGo(): UserSignInGoController
    {
        $result = new Result();

        try {

            $login = $this->getUserInputData("login", 255) ?? "";
            $password = $this->getUserInputData("password", 255) ?? "";

            $user = (new FindUserByLogin($login))->getUser();
            if (!$user || !$user->getUserId()) {
                throw new CallableControllerException("Пользователь с указанным логином не найден");
            }

            if (!password_verify($password, $user->getPasswordHash())) {
                throw new CallableControllerException("Указанный вами пароль указан неверно");
            }

            if (password_needs_rehash($user->getPasswordHash(), PASSWORD_DEFAULT)) {
                // @todo password need to rehash
                throw new ApplicationError("Error ... Need to code it");
            }

            Auth::getInstance()->set($user);

            $this->getView()->setUser($user);


        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());

        } finally {
            $this->getView()->setResult($result);
        }

        return $this;
    }
}