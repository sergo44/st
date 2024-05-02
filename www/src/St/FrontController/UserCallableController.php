<?php

namespace St\FrontController;

use St\ApplicationError;
use St\Auth;
use St\HttpError403Exception;
use St\Layouts\ILayout;
use St\User;
use St\Views\IView;

class UserCallableController extends CallableController
{
    /**
     * Контроллер для пользователя, в случае если пользователь не авторизирован - выполняется возврат ошибки
     * @throws ApplicationError
     * @throws HttpError403Exception
     */
    public function __construct(array $user_input_data, ILayout $layout, IView $view)
    {
        if (!Auth::getInstance()->get() || !Auth::getInstance()->get()->getUserId()) {
            throw new HttpError403Exception();
        }

        parent::__construct($user_input_data, $layout, $view);
    }

    /**
     * Возвращает текущего пользователя
     * @throws ApplicationError
     */
    public function getUser(): User
    {
        return Auth::getInstance()->get();
    }
}