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
     * For implements ILayout
     * @var array
     */
    protected array $js = array();

    /**
     * Устанавливает result
     * @param Result $result
     * @return JsonView
     * @see result
     */
    public function setResult(Result $result): JsonView
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Возвращает вид
     * @return Result
     */
    public function getResult(): Result
    {
        return $this->result;
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