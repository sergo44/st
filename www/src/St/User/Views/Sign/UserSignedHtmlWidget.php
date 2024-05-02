<?php

namespace St\User\Views\Sign;

use St\User;
use St\Views\HtmlView;

class UserSignedHtmlWidget extends HtmlView
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function out(): void
    {
        ?>
        <div class="header__wrapper-entry header__account-name gap-4 col-sm-auto col d-flex justify-content-end align-items-center" href="#">
            <a href="/User/Account"><?php print $this->escape($this->user->getName());?></a>
            <div class="header__wrapper-account-image d-flex align-items-center justify-content-center position-relative">
                <div class="red-label position-absolute"></div>
                <img alt="" src="/images/icons/account-person.svg">
            </div>
            <a class="mobile-menu__icon col-auto d-md-none d-block" href="#">
                <img alt="" src="/images/icons/burger.svg">
            </a>
        </div>
        <?php
    }
}