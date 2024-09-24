<?php

namespace St\User\CallableControllers;

use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\User\GetAllUsers;

class ListUsersAccountsController extends UserCallableController implements ICallableController
{
    public function index(): self
    {
        $this->getLayout()
            ->setSectionTitle("Управление пользователями")
        ;

        $this->getView()
            ->setResult( $result = new Result() )
        ;

        try {

            $users = (new GetAllUsers())->getUsers();

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}