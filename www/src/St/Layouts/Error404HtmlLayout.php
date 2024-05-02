<?php

namespace St\Layouts;

class Error404HtmlLayout extends HtmlLayout implements ILayout
{
    /**
     * Отображает шаблон (отправляет в STDOUT)
     * @todo Сделать красивую страницу Ошибки 404
     * @return void
     */
    public function out(): void
    {
        if (!headers_sent()) {
            header("HTTP/1.1 404 Not Found");
            header("Content-Type: {$this->getContentMimeType()}; charset={$this->getDefaultCharset()}");
        }

        ?>

        <html lang="ru"><head><title>Ой, страница не найдена</title><body>Ошибка 404. Указанная страница не найдена</body></head></html>

        <?php
    }
}