<?php

namespace St\Layouts;

interface ILayout
{
    public function setSectionTitle(string $title): ILayout;
    /**
     * Устанавливает контент
     * @param string $content
     * @return ILayout
     */
    public function setContent(string $content): ILayout;

    /**
     * Добавляет JS файл, необходимый для дополнительной загрузки
     * @param string $path
     * @return ILayout
     */
    public function addJs(string $path): ILayout;

    /**
     * Выводит шаблон в STDOUT
     * @return void
     */
    public function out(): void;

    /**
     * Возвращает шиблон
     * @return string
     */
    public function fetch(): string;
}