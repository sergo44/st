<?php

namespace St\FrontController;

use St\Layouts\ILayout;
use St\Views\IView;

interface ICallableController
{
    /**
     * Возвращает шаблон
     * @see ILayout
     * @return ILayout
     */
    public function getLayout(): ILayout;

    /**
     * Возвращает вид для отображения
     * @see IView
     * @return IView
     */
    public function getView(): IView;
}