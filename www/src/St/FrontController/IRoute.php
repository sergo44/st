<?php

namespace St\FrontController;

interface IRoute
{
    /**
     * Пробуем найти маршрут в указанном классе
     * @return ICallableController|null
     */
    public function tryRoute(): ICallableController|null;

}