<?php

namespace St\User\CallableControllers;

use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;

class UserAccountController extends UserCallableController implements ICallableController
{
    public function index(): ICallableController
    {
        return $this;
    }
}