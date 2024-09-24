<?php

namespace St\User\Views\Emails;

use St\User;
use St\Utils;
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
     * Возвращает URL для подтверждения адреса электронной почты
     * @return string
     */
    protected function getConfirmationUrl(): string
    {
        return sprintf("%s/User/%u/EmailConfirmation?code=%s", Utils::site_url(), $this->getUser()->getUserId(), $this->getUser()->getEmailConfirmationCode());
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
        <div>Ваш адрес электронной почты указан при регистрации на сайте "Собери Тур" <a href="<?php print Utils::site_url();?>">https://<?php print Utils::site_url();?></a></div>
        <div>
            Для того, что бы подтвердить адрес электронной почты, пожалуйста укажите код <strong><?php print $this->user->getEmailConfirmationCode();?></strong> или
            перейдите по ссылке
        </div>
        <div></div>
        </body>
        </html>
        <?php
    }


}