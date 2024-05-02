<?php

namespace St\User\CallableControllers;

use St\ApplicationError;
use St\Auth;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\Result;
use St\User;
use St\Views\IView;

class UserRegisterGoController extends CallableController implements ICallableController
{
    /**
     * @inheritDoc
     * @return User\Views\UserRegister\UserRegisterGoJsonView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Регистрация пользователя
     * @return $this
     * @throws ApplicationError
     */
    public function index(): UserRegisterGoController
    {
        $user = new User();
        $result = new Result();

        $this->getView()
            ->setResult($result)
            ->setUser($user);

        $user
            ->setName($this->getUserInputData("name", 255) ?? "")
            ->setLogin($this->getUserInputData("login", 255) ?? "")
            ->setTimezone("Europe/Moscow")
            ->setEmail($this->getUserInputData("email", 255) ?? "")
            ->setPhone($this->getUserInputData("phone", 255) ?? "")
            ->setPassword($this->getUserInputData("password") ?? "")
            ->setPasswordHash(password_hash($this->getUserInputData("password") ?? "",  PASSWORD_DEFAULT))
        ;

        $register = new User\Register($user);
        $register
            ->setPasswordConfirm($this->getUserInputData("password_confirm") ?? "")
            ->check($result);

        if ($result->isSuccess()) {
            $register->addToDb();
            Auth::getInstance()->set($user);
        }

        return $this;
    }
}