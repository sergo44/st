<?php

namespace St\User\Views\Sign;

use St\Views\HtmlView;

class UserSignInHtmlWidget extends HtmlView
{
    public function out(): void
    {
        ?>

        <div id="jsSignInWidget" class="header__wrapper-entry row gap-4 col-sm-auto col justify-content-end align-items-center">
            <a class="btn btn-warning col-auto" data-bs-target="#entryForm" data-bs-toggle="modal" href="#" onclick="event.preventDefault()" role="button">Войти</a>
            <a class="mobile-menu__icon col-auto d-md-none d-block" href="#">
                <img alt="" src="/images/icons/burger.svg">
            </a>
        </div>

        <?php
    }
}