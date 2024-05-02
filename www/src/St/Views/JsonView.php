<?php

namespace St\Views;

use St\Result;

abstract class JsonView
{
    /**
     * Результат выполнения запроса, переданный в вид
     * @var Result
     */
    protected Result $result;

    /**
     * Возвращает вид
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->result;
    }

    /**
     * Устанавливает результат
     * @param Result $result
     * @return $this
     */
    public function setResult(Result $result): JsonView
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Возвращает шаблон
     * @return string
     */
    public function fetch(): string
    {
        return json_encode($this);
    }

    /**
     * Выводит шаблоны
     * @return void
     */
    public function out(): void
    {
        print $this->fetch();
    }
}