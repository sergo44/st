<?php

namespace St\StaticContent\CallableControllers;

use St\FrontController\CallableController;
use St\FrontController\ICallableController;

class StaticContentController extends CallableController implements ICallableController
{
    public function index(): StaticContentController
    {
        return $this;
    }
}