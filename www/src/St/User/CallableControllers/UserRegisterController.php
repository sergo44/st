<?php

namespace St\User\CallableControllers;


use St\Db;
use St\ErrorResult;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\User;

class UserRegisterController extends CallableController implements ICallableController
{
    public function index(): UserRegisterController
    {
        /** @todo No Sign in page yet */
        return $this;
    }

    public function doRegister(): UserRegisterController
    {
        try {


        } catch (CallableControllerException $e) {
            $this->getView()->getResult((new ErrorResult($e->getMessage(0))));
        }

        return $this;
    }
}