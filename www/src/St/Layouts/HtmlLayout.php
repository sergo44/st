<?php

namespace St\Layouts;

use St\Views\HtmlView;

class HtmlLayout extends HtmlView implements ILayout
{
    /**
     * Кодировка по умолчанию
     * @var string
     */
    protected string $default_charset = "UTF-8";
    /**
     * Тип контента по умолчанию
     * @var string
     */
    protected string $content_mime_type = "text/html";
    /**
     * JS Файлы для подключения
     * @var string[]
     */
    protected array $js_files = array("/build/common.bundle.js");
    /**
     * Заголовок раздела
     * @var string
     */
    protected string $section_title = "";
    /**
     * Содержимое для отображения
     * @var string
     */
    protected string $content = "";

    /**
     * Возвращает default_charset
     * @return string
     * @see default_charset
     */
    public function getDefaultCharset(): string
    {
        return $this->default_charset;
    }

    /**
     * Устанавливает default_charset
     * @param string $default_charset
     * @return $this
     * @see default_charset
     */
    public function setDefaultCharset(string $default_charset): ILayout
    {
        $this->default_charset = $default_charset;
        return $this;
    }

    /**
     * Возвращает content_mime_type
     * @see content_mime_type
     * @return string
     */
    public function getContentMimeType(): string
    {
        return $this->content_mime_type;
    }

    /**
     * Устанавливает content_mime_type
     * @see content_mime_type
     * @param string $content_mime_type
     * @return $this
     */
    public function setContentMimeType(string $content_mime_type): ILayout
    {
        $this->content_mime_type = $content_mime_type;
        return $this;
    }

    /**
     * Добавляет JS файл для загрузки
     * @param string $path
     * @return ILayout
     */
    public function addJs(string $path): ILayout
    {
        $this->js_files[] = $path;
        return $this;
    }

    /**
     * Возвращает section_title
     * @return string
     * @see section_title
     */
    public function getSectionTitle(): string
    {
        return $this->section_title;
    }

    /**
     * Устанавливает section_title
     * @param string $section_title
     * @return HtmlLayout
     * @see section_title
     */
    public function setSectionTitle(string $section_title): HtmlLayout
    {
        $this->section_title = $section_title;
        return $this;
    }

    /**
     * Возвращает content
     * @return string
     * @see content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Устанавливает content
     * @param string $content
     * @return HtmlLayout
     * @see content
     */
    public function setContent(string $content): HtmlLayout
    {
        $this->content = $content;
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
     * Отображает шаблон (отправляет в STDOUT)
     * @return void
     */
    public function out(): void
    {
        if (!headers_sent()) {
            header("Content-Type: {$this->getContentMimeType()}; charset=charset={$this->getDefaultCharset()}");
        }

        ?>

        <html lang="ru"><head><title>I am default html layout</title><body>I am default html layout with content <?php print $this->getContent();?></body></head></html>

        <?php
    }
}