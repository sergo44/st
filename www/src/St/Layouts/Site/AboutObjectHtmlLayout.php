<?php

namespace St\Layouts\Site;

use St\ApplicationError;use St\Auth;use St\BreadCrumbs;use St\Db;use St\Db\Views\ProfileHtmlView;use St\Layouts\HtmlLayout;
use St\Layouts\ILayout;use St\Layouts\Site\CommonHtmlWidgets\RegisterFormHtmlWidget;use St\Layouts\Site\CommonHtmlWidgets\RestoreAccessHtmlWidget;use St\Layouts\Site\CommonHtmlWidgets\SignInFormHtmlWidget;use St\User\Views\Sign\UserSignedHtmlWidget;use St\User\Views\Sign\UserSignInHtmlWidget;use St\Utils\TemplatesUtils;

class AboutObjectHtmlLayout extends HtmlLayout implements ILayout
{
/**
 * @throws ApplicationError
 */#[\Override] public function out(): void
    {
        ?><!doctype html>
<html lang="en">
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

<header class="header d-flex align-items-center">
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

            <?php if (!Auth::getInstance()->get() || !Auth::getInstance()->get()->getUserId()):?>
                <?php (new UserSignInHtmlWidget())->out();?>
            <?php else: ?>
                <?php (new UserSignedHtmlWidget(Auth::getInstance()->get()))->out();?>
            <?php endif; ?>

        </div>
    </div>
</header>
<main>
    <section class="section-object">
        <div class="container">
            <ul class="breadcrumbs d-flex align-items-center flex-wrap">
                <?php foreach (BreadCrumbs::getInstance()->get() as $key => $item):?>
                    <?php if ($item->getUri()):?>
                        <li><a href="<?php print $item->getUri()?>"><?php print $item->getLabel();?></a><span> <?php print $key < sizeof(BreadCrumbs::getInstance()->get()) - 1 ? "/" : null;?> </span></li>
                    <?php else: ?>
                        <li><a href="<?php print $item->getUri()?>"><?php print $item->getLabel();?></a><span> <?php print $key < sizeof(BreadCrumbs::getInstance()->get()) - 1  ? "/" : null;?>  </span></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <h1><?php print $this->getSectionTitle();?></h1>
            <?php print $this->getContent();?>

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