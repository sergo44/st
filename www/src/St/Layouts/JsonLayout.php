<?php

namespace St\Layouts;

use St\Result;

class JsonLayout implements ILayout
{
    /**
     * Результат выполнения операции
     * @var Result
     */
    protected Result $result;
    /**
     * Наименование раздела (общий для Layout)
     * @var string
     */
    protected string $section_title;
    /**
     * Контент для отображения
     * @var string|null
     */
    protected string|null $content = null;
    /**
     * JS файлы, которые необходимо подключить
     * @var string[]
     */
    protected array $js = array();


    /**
     * Устанавливают заголовок страниц
     * @param string $title
     * @return ILayout
     */
    #[\Override] public function setSectionTitle(string $title): ILayout
    {
        $this->section_title = $title;
        return $this;
    }

    /**
     * Устанавливаем контент для отображения в шаблоне
     * @param string $content
     * @return ILayout
     */
    #[\Override] public function setContent(string $content): ILayout
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Устанавливает результат
     * @param Result $result
     * @return JsonLayout
     */
    public function setResult(Result $result): JsonLayout
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Добавление JS
     * @param $path
     * @return ILayout
     */
    public function addJs($path): ILayout
    {
        $this->js[] = $path;
        return $this;
    }

    /**
     * Вывод шаблона
     * @return void
     */
    #[\Override] public function out(): void
    {
        if (!headers_sent()) {
            header("Content-type: application/json; charset=utf-8");
        }

        print $this->fetch();
    }

    /**
     * Возврат шаблона
     * @return string
     */
    #[\Override] public function fetch(): string
    {
        return $this->content;
    }
}