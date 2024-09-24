<?php

namespace St\User\Views\Emails;

use St\User;
use St\Views\HtmlView;
use St\Views\IView;

class EmailConfirmationCodeHtmlView extends HtmlView implements IView
{
    /**
     * Пользователь, для которого выполняется выборка
     * @var User
     */
    protected User $user;

    /**
     * Возвращает user
     * @return User
     * @see user
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Устанавливает user
     * @param User $user
     * @return EmailConfirmationCodeHtmlView
     * @see user
     */
    public function setUser(User $user): EmailConfirmationCodeHtmlView
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @inheritDoc
     * @return void
     */
    public function out(): void
    {
        ?>
        <html lang="ru">
        <head>
            <title>Подтверждение адреса электронной почты</title>
        </head>
        <body>
        <div><strong>Здравствуйте, <?php print $this->user->getName();?></strong></div>
        <div>Ваш адрес электронной почты указан при регистрации на сайте <?php ST_SMTP_HOST?></div>
        </body>
        </html>
        <?php
    }


}