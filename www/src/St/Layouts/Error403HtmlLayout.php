<?php

namespace St\Layouts;

class Error403HtmlLayout extends HtmlLayout implements ILayout
{
    /**
     * Отображает шаблон (отправляет в STDOUT)
     * @todo Сделать красивую страницу ошибки 403 с формой входа
     * @return void
     */
    public function out(): void
    {
        if (!headers_sent()) {
            header("HTTP/1.1 403 Forbidden");
            header("Content-Type: {$this->getContentMimeType()}; charset={$this->getDefaultCharset()}");
        }

        ?>

        <html lang="ru"><head><title>Ой, доступ запрещен</title><body>Ошибка 403. Доступ к указанной странице запрещен</body></head></html>

        <?php
    }
}