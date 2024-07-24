<?php

namespace St\Views;

use St\Result;

abstract class HtmlView
{
    /**
     * Результат выполнения
     * @var Result
     */
    protected Result $result;

    /**
     * Возвращает result
     * @return Result
     * @see result
     */
    public function getResult(): Result
    {
        return $this->result;
    }

    /**
     * Устанавливает result
     * @param Result $result
     * @return HtmlView
     * @see result
     */
    public function setResult(Result $result): HtmlView
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
        ob_start();
        $this->out();
        return ob_get_clean();
    }

    /**
     * Выводит шаблон
     * @return void
     */
    public function out(): void
    {
        echo "<h1>I am base HTML view</h1><p>I am base HTML View</p>";
    }

    /**
     * Выполняет Escape HTML строки
     * @param mixed $escape_string
     * @param bool $nl2br
     * @return string
     */
    public function escape(mixed $escape_string, bool $nl2br = false): string
    {
        $content = htmlspecialchars(string: (string)$escape_string, encoding: 'UTF-8');
        return $nl2br ? nl2br($content) : $content;
    }
}