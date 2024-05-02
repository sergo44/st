<?php

namespace St\Views;

use St\Result;

interface IView
{
    /**
     * Возвращает результат
     * @return Result
     */
    public function getResult(): Result;

    /**
     * Устанавливает результат
     * @param Result $result
     * @return self
     */
    public function setResult(Result $result);

    /**
     * Возвращает шаблон
     * @return string
     */
    public function fetch(): string;

    /**
     * Выводит шаблон в STDOUT
     * @return void
     */
    public function out(): void;
}