<?php

namespace St\FrontController;

class FileRoute
{
    /**
     * Диспетчер, который вызывает маршрут
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * FileController constructor
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}