<?php

namespace St\Layouts\Site;

use St\ApplicationError;
use St\Auth;
use St\Db;
use St\Db\Views\ProfileHtmlView;
use St\Layouts\HtmlLayout;
use St\Layouts\ILayout;
use St\Layouts\Site\CommonHtmlWidgets\RegisterFormHtmlWidget;
use St\Layouts\Site\CommonHtmlWidgets\RestoreAccessHtmlWidget;
use St\Layouts\Site\CommonHtmlWidgets\SignInFormHtmlWidget;
use St\Utils\TemplatesUtils;

class UserHtmlLayout extends HtmlLayout implements ILayout
{
    /**
     * @throws ApplicationError
     */
    public function out(): void
    {
       ?>

        <!doctype html><html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
                  name="viewport">
            <meta content="ie=edge" http-equiv="X-UA-Compatible">
            <title>Собери свой тур</title>
            <link href="https://fonts.googleapis.com" rel="preconnect">
            <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
                  rel="stylesheet">
            <link href="https://fonts.googleapis.com" rel="preconnect">
            <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
            <script src="/build/style.bundle.js"></script>
        </head>
        <body>
        <!------------------------------------------Оверлэй------------------------------------------------------>
        <div class="overlay w-100 h-100 position-fixed z-3 d-none"></div>

        <?php (new SignInFormHtmlWidget())->out();?>

        <?php (new RestoreAccessHtmlWidget())->out(); ?>

        <?php (new RegisterFormHtmlWidget())->out(); ?>

        <!-- <div class="read-only d-flex align-items-center justify-content-center">
            <span class="p-3">Ваша учетная запись находится в режиме Read Only (только чтение). <a class="link-warning ps-1 pe-1" href="#">Подтвердите</a> адрес электронной почты.</span>
        </div> -->

        <header class="header d-flex flex-column align-items-center justify-content-center">
            <div class="header-menu position-fixed top-0 start-0 z-3 w-100 h-100 bg-light">
                <div class="header-menu__wrapper-close p-5 position-absolute top-0 end-0 z-3">
                    <img alt="" src="/images/icons/close.svg" style="margin-right: -.6rem">
                </div>
                <div class="col-sm-auto col-auto d-flex align-items-center">
                    <div class="header__wrapper-logo me-3 flex-shrink-0">
                        <img alt="" src="/images/logo.svg">
                    </div>
                    <a class="header__wrapper-logo-title" href="/">
                        <div class="header__logo-title">Собери тур</div>
                    </a>
                </div>
                <ul class="header-menu__list d-flex flex-column gap-5">
                    <li><a href="/Catalog/Objects/Hotels">Гостиницы</a></li>
                    <li><a href="/Catalog/Objects/Guest_House">Гостевые дома</a></li>
                    <li><a href="/Catalog/Objects/Hostel">Хостелы</a></li>
                    <li><a href="/Catalog/Objects/Apartment">Апартаменты</a></li>
                    <li><a href="/Catalog/Objects/Camping">Кемпинг</a></li>
                </ul>
            </div>
            <div class="container h-100">
                <div class="row align-items-center justify-content-sm-between h-100 w-100">
                    <div class="col-sm-auto col-auto d-flex align-items-center">
                        <div class="header__wrapper-logo me-3 flex-shrink-0">
                            <img alt="" src="/images/logo.svg">
                        </div>
                        <a class="header__wrapper-logo-title" href="/">
                            <div class="header__logo-title">Собери тур</div>
                            <div class="header-logo__gray-text mt-2">выбирай, что нравится</div>
                        </a>
                    </div>
                    <a
                        class="header__wrapper-search col-sm-1 col-auto d-none d-sm-flex justify-content-center align-items-center h-100 border-start border-end"
                        href="#">
                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.06238 15.625C12.6867 15.625 15.6249 12.6869 15.6249 9.0625C15.6249 5.43813 12.6867 2.5 9.06238 2.5C5.43801 2.5 2.49988 5.43813 2.49988 9.0625C2.49988 12.6869 5.43801 15.625 9.06238 15.625Z"
                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.7025 13.7031L17.4994 17.5" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <ul class="header__menu col-sm-6 row align-items-center justify-content-between d-md-flex d-sm-none d-none">
                        <li class="col-auto"><a href="/Catalog/Objects/Hotels">Гостиницы</a></li>
                        <li class="col-auto"><a href="/Catalog/Objects/Guest_House">Гостевые дома</a></li>
                        <li class="col-auto"><a href="/Catalog/Objects/Hostel">Хостелы</a></li>
                        <li class="col-auto"><a href="/Catalog/Objects/Apartment">Апартаменты</a></li>
                        <li class="col-auto"><a href="/Catalog/Objects/Camping">Кемпинг</a></li>
                    </ul>
                    <a
                        class="header__wrapper-entry header__account-name gap-4 col-sm-auto col d-flex justify-content-end align-items-center"
                        href="#">
                        <?php print $this->escape(Auth::getInstance()->get()->getName());?>
                        <div class="header__wrapper-account-image d-flex align-items-center justify-content-center position-relative">
                            <div class="red-label position-absolute"></div>
                            <img alt="" src="/images/icons/account-person.svg">
                        </div>
                        <a class="mobile-menu__icon col-auto d-md-none d-block" href="#">
                            <img alt="" src="/images/icons/burger.svg">
                        </a>
                    </a>
                </div>
            </div>
        </header>
        <main>
            <section class="section-profile">
                <div class="container">
                    <div class="section-profile__wrapper d-grid">

                        <div class="section-profile__side-bar">
                            <div class="section-profile__side-bar-top d-flex flex-column align-items-center gap-3 p-4">
                                <div class="section-profile__wrapper-photo">
                                    <img alt="" src="/images/account-photo.png">
                                </div>
                                <div class="section-profile__account-name">
                                    <?php print $this->escape(Auth::getInstance()->get()->getName());?>
                                </div>
                            </div>
                            <ul class="section-profile__links">
                                <li class="mb-4"><a class="active" href="/User/Account">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                    d="M10 12.5C12.7614 12.5 15 10.2614 15 7.5C15 4.73858 12.7614 2.5 10 2.5C7.23858 2.5 5 4.73858 5 7.5C5 10.2614 7.23858 12.5 10 12.5Z"
                                                    stroke="#f87506" stroke-miterlimit="10"/>
                                            <path
                                                    d="M2.4209 16.8743C3.1893 15.5442 4.29419 14.4398 5.62456 13.672C6.95493 12.9042 8.46393 12.5 9.99997 12.5C11.536 12.5 13.045 12.9043 14.3754 13.6721C15.7057 14.44 16.8106 15.5444 17.579 16.8744"
                                                    stroke="#f87506" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Профиль
                                    </a></li>
                                <li class="mb-4"><a href="/Catalog/ListObjects">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M3.125 16.875V3.75" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                    d="M3.125 13.1255C8.125 9.3755 11.875 16.8755 16.875 13.1255V3.7505C11.875 7.5005 8.125 0.000500485 3.125 3.7505"
                                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Мои объявления
                                    </a></li>
                                <li class="mb-4 d-none"><a href="#">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                    d="M4.39083 8.12495C4.38979 7.38371 4.53548 6.64959 4.81948 5.96491C5.10349 5.28024 5.52021 4.65854 6.0456 4.13567C6.571 3.61279 7.1947 3.19907 7.88073 2.91837C8.56677 2.63766 9.30158 2.49551 10.0428 2.50011C13.1358 2.5231 15.6097 5.09396 15.6097 8.19557V8.74995C15.6097 11.548 16.1951 13.1717 16.7107 14.0592C16.7663 14.154 16.7958 14.2618 16.7964 14.3717C16.797 14.4816 16.7686 14.5897 16.7141 14.6851C16.6596 14.7805 16.5808 14.8599 16.4859 14.9151C16.3909 14.9704 16.283 14.9997 16.1731 15H3.82681C3.71691 14.9997 3.60902 14.9704 3.51403 14.9151C3.41905 14.8598 3.34032 14.7805 3.2858 14.685C3.23128 14.5896 3.20289 14.4815 3.2035 14.3716C3.20411 14.2617 3.23369 14.1539 3.28926 14.059C3.80514 13.1716 4.39082 11.5479 4.39082 8.74995L4.39083 8.12495Z"
                                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                    d="M7.5 15V15.625C7.5 16.288 7.76339 16.9239 8.23223 17.3928C8.70107 17.8616 9.33696 18.125 10 18.125C10.663 18.125 11.2989 17.8616 11.7678 17.3928C12.2366 16.9239 12.5 16.288 12.5 15.625V15"
                                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Уведомления
                                    </a></li>
                                <li class="mb-4"><a href="#">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.5946 6.71875L16.875 10L13.5946 13.2812" stroke="#170B00" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M8.125 10H16.8727" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                    d="M8.125 16.875H3.75C3.58424 16.875 3.42527 16.8092 3.30806 16.6919C3.19085 16.5747 3.125 16.4158 3.125 16.25V3.75C3.125 3.58424 3.19085 3.42527 3.30806 3.30806C3.42527 3.19085 3.58424 3.125 3.75 3.125H8.125"
                                                    stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Выход
                                    </a></li>
                            </ul>
                        </div>

                        <div class="section-profile__main">
                            <h1><?php print $this->getSectionTitle()?></h1>
                            <?php print $this->getContent()?>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer d-flex align-items-center">
            <div class="container">
                <div class="footer__wrapper d-flex align-items-center justify-content-between">
                    <p>© Собери тур, 2023 г. Все пpава защищены</p>
                    <div class="footer__wrapper-policy d-flex flex-column flex-sm-row align-items-center gap-3">
                        <a href="#">Политика конфиденциальности</a>
                        <a href="#">Условия использования</a>
                    </div>
                </div>
            </div>
        </footer>

        <?php foreach ($this->js_files as $js_file):?>
            <script src="<?php print TemplatesUtils::require_js($js_file);?>"></script>
        <?php endforeach; ?>


        <?php if (defined("ST_DEVELOPMENT_VERSION") && ST_DEVELOPMENT_VERSION) {
            (new ProfileHtmlView())->setRows( Db::getDbProfiles() )->out();
        } ?>

        </body>
        </html>

        <?php
    }
}