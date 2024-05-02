<?php

namespace St\Layouts;

class JsonLayout implements ILayout
{
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