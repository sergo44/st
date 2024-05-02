<?php

namespace St\Layouts\Site;

use St\ApplicationError;
use St\Auth;
use St\Layouts\HtmlLayout;
use St\Layouts\ILayout;
use St\Layouts\Site\CommonHtmlWidgets\RegisterFormHtmlWidget;
use St\Layouts\Site\CommonHtmlWidgets\RestoreAccessHtmlWidget;use St\Layouts\Site\CommonHtmlWidgets\SignInFormHtmlWidget;
use St\User\Views\Sign\UserSignedHtmlWidget;
use St\User\Views\Sign\UserSignInHtmlWidget;
use St\Utils\TemplatesUtils;

class IndexHtmlLayout extends HtmlLayout implements ILayout
{
    /**
     * Вывод шаблона
     * @return void
     * @throws ApplicationError
     */
    public function out(): void
    {
        ?>

        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" name="viewport">
            <meta content="ie=edge" http-equiv="X-UA-Compatible">
            <title>Собери свой тур</title>
            <link href="https://fonts.googleapis.com" rel="preconnect">
            <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com" rel="preconnect">
            <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
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
                    <li><a href="">Проживание</a></li>
                    <li><a href="">Питание</a></li>
                    <li><a href="">Прокат</a></li>
                    <li><a href="">Экскурсии и туры</a></li>
                    <li><a href="">Достопримечательности</a></li>
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
                        <li class="col-auto"><a href="/catalog.html">Проживание</a></li>
                        <li class="col-auto"><a href="#">Питание</a></li>
                        <li class="col-auto"><a href="#">Экскурсии и туры</a></li>
                        <li class="col-auto"><a href="#">Прокат</a></li>
                        <li class="col-auto"><a href="#">Достопримечательности</a></li>
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
            <section class="index__wrapper-banner d-flex flex-column justify-content-center"
                     style="background:url('/images/bg-banner.png'); background-repeat: no-repeat;background-size: cover; background-position: center;">
                <div class="container">
                    <h1>Организуй свое идеальное <br> путешествие с нами</h1>
                    <p>Отдых в Иркутской области и республике Бурятия </p>
                    <div class="index-banner__wrapper-search row justify-content-center">
                        <div class="index-banner__search-block col-sm-9 col-12" style="margin-top: 13.6rem">
                            <ul class="index-banner__search-tabs d-grid">
                                <li>
                                    <button aria-pressed="true" class="btn btn-light d-flex align-items-center gap-2 active"
                                            data-bs-toggle="button"
                                            type="button">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.25 16.873H18.75" stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M11.2495 16.873V3.12305C11.2495 2.95729 11.1837 2.79832 11.0665 2.68111C10.9492 2.56389 10.7903 2.49805 10.6245 2.49805H3.12451C2.95875 2.49805 2.79978 2.56389 2.68257 2.68111C2.56536 2.79832 2.49951 2.95729 2.49951 3.12305V16.873"
                                                stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M17.4995 16.873V8.12305C17.4995 7.95729 17.4337 7.79832 17.3165 7.68111C17.1992 7.5639 17.0403 7.49805 16.8745 7.49805H11.2495"
                                                stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M4.99951 5.62305H7.49951" stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.24951 10.623H8.74951" stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M4.99951 13.748H7.49951" stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M13.7495 13.748H14.9995" stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M13.7495 10.623H14.9995" stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Проживание
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="button" type="button">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.5625 2.5V5.625" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.5625 9.0625V17.5" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M8.75 2.5L9.375 6.25C9.375 6.99592 9.07868 7.71129 8.55124 8.23874C8.02379 8.76618 7.30842 9.0625 6.5625 9.0625C5.81658 9.0625 5.10121 8.76618 4.57376 8.23874C4.04632 7.71129 3.75 6.99592 3.75 6.25L4.375 2.5"
                                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M15.9375 12.5H11.5625C11.5625 12.5 12.5 3.75 15.9375 2.5V17.5" stroke="#170B00"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Питание
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="button" type="button">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.875 5.625C12.9105 5.625 13.75 4.78553 13.75 3.75C13.75 2.71447 12.9105 1.875 11.875 1.875C10.8395 1.875 10 2.71447 10 3.75C10 4.78553 10.8395 5.625 11.875 5.625Z"
                                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M3.75 10.0007C3.75 10.0007 8.125 5.62569 10.625 7.93437C12.0266 9.22873 13.125 11.2507 16.25 11.2507"
                                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M10.1961 7.61133L5.625 18.1249" stroke="#170B00" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M11.875 18.1255V13.7505L8.5575 11.3809" stroke="#170B00" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                        Экскурсии и туры
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-light d-flex align-items-center gap-3" data-bs-toggle="button" type="button">
                                        <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M16.25 6.25C16.25 5.91848 16.1183 5.60054 15.8839 5.36612C15.6495 5.1317 15.3315 5 15 5H11.875L16.25 12.5"
                                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M16.25 15.625C17.9759 15.625 19.375 14.2259 19.375 12.5C19.375 10.7741 17.9759 9.375 16.25 9.375C14.5241 9.375 13.125 10.7741 13.125 12.5C13.125 14.2259 14.5241 15.625 16.25 15.625Z"
                                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path
                                                d="M3.75 15.625C5.47589 15.625 6.875 14.2259 6.875 12.5C6.875 10.7741 5.47589 9.375 3.75 9.375C2.02411 9.375 0.625 10.7741 0.625 12.5C0.625 14.2259 2.02411 15.625 3.75 15.625Z"
                                                stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M3.75 5H5.9375L10.3125 12.5" stroke="#170B00" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                            <path d="M13.288 7.5H7.39586L3.75 12.5" stroke="#170B00" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                        Прокат
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-light d-flex align-items-center gap-2" data-bs-toggle="button" type="button">
                                        <svg fill="none" height="20" viewBox="0 0 21 20" width="21" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 1.25L4.25 9.375H7.375L3 15H18L13.625 9.375H16.75L10.5 1.25Z" stroke="#170B00"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M10.5 15V18.75" stroke="#170B00" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Достопримечательности
                                    </button>
                                </li>
                            </ul>
                            <div class="input-group" style="margin-top: 0.2rem">
                                <input aria-describedby="basic-addon2" aria-label="Имя пользователя получателя"
                                       class="form-control rounded-0"
                                       placeholder="Введите регион или место"
                                       style="height:6rem;"
                                       type="text">
                                <span class="input-group-text p-0 border-0" id="basic-addon2">
          <button class="btn btn-warning rounded-0 h-100" type="submit">
              <svg fill="none" height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                  <path
                      d="M9.06226 15.625C12.6866 15.625 15.6248 12.6869 15.6248 9.0625C15.6248 5.43813 12.6866 2.5 9.06226 2.5C5.43789 2.5 2.49976 5.43813 2.49976 9.0625C2.49976 12.6869 5.43789 15.625 9.06226 15.625Z"
                      stroke="#FDFDFD" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M13.7024 13.7031L17.4993 17.5" stroke="#FDFDFD" stroke-linecap="round"
                        stroke-linejoin="round"/>
              </svg>
          </button>
        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-popular">
                <div class="container">
                    <h2>Популярные направления</h2>
                    <ul class="section-popular__list row">
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Тёплые озера</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/house.svg">
                                        <span>Отели, гостевые дома, хостелы, квартиры, кемпинги </span>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/bus.svg">
                                        <span>Автобус, автомобиль, катер</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Листвянка</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/house.svg">
                                        <span>Отели, гостевые дома, хостелы, квартиры, кемпинги </span>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/bus.svg">
                                        <span>Автобус, автомобиль, катер</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-12">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Ольхон</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/house.svg">
                                        <span>Отели, гостевые дома, хостелы, квартиры, кемпинги </span>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/bus.svg">
                                        <span>Автобус, автомобиль, катер</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-8 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Тёплые озера на реке Снежная</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/house.svg">
                                        <span>Отели, гостевые дома, хостелы, квартиры, кемпинги </span>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/bus.svg">
                                        <span>Автобус, автомобиль, катер</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/house.svg">
                                        <span>Отели, гостевые дома, хостелы, квартиры, кемпинги </span>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/bus.svg">
                                        <span>Автобус, автомобиль, катер</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-12">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/house.svg">
                                        <span>Отели, гостевые дома, хостелы, квартиры, кемпинги </span>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/bus.svg">
                                        <span>Автобус, автомобиль, катер</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

            </section>
            <section class="section-hotels">
                <div class="container">
                    <h2>Отели и гостиницы на <br> берегу Байкала</h2>
                    <ul class="section-popular__list section-hotels__list row">
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/hotel.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/geo.svg">
                                        <span>р.п. Листвянка, улица Горького, 85</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/hotel.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/geo.svg">
                                        <span>р.п. Листвянка, улица Горького, 85</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-12">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/hotel.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <img alt="" src="/images/icons/geo.svg">
                                        <span>р.п. Листвянка, улица Горького, 85</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        </li>
                    </ul>
                    <a class="btn btn-outline-secondary" href="#">Смотреть еще</a>
                </div>
            </section>
            <section class="section-popular">
                <div class="container">
                    <h2>Популярные <br>достопримечательности</h2>
                    <ul class="section-popular__list row">
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <span>Мыс в средней части западного побережья острова Ольхон, на озере Байкал.</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-8 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Тёплые озера на реке Снежная</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <span>Хобой - самый северный край Ольхона. Отсюда открывается прекрасный и незабываемый вид на огромные водные просторы озера.</span>
                                    </div>

                                </div>
                            </a>
                        </li>
                        <li class="col-lg-8 col-12">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Тёплые озера на реке Снежная</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <span>Хобой - самый северный край Ольхона. Отсюда открывается прекрасный и незабываемый вид на огромные водные просторы озера.</span>
                                    </div>

                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <span>Мыс в средней части западного побережья острова Ольхон, на озере Байкал.</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="col-lg-4 col-6">
                            <a class="card border-0" href="#">
                                <img alt="тур" class="card-img-top rounded-0" src="/images/card-image.jpg">
                                <div class="card-body">
                                    <h5 class="card-title mt-2">Аршан</h5>
                                    <div class="card-raiting d-flex align-items-center gap-3">
                                        <span>4.9</span>
                                        <div class="card-raiting__wrapper-stars">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/star.svg">
                                            <img alt="" src="/images/icons/semi-star.svg">
                                        </div>
                                    </div>
                                    <div class="card__wrapper-house d-flex align-items-center gap-3 mt-2">
                                        <span>Мыс в средней части западного побережья острова Ольхон, на озере Байкал.</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <a class="btn btn-outline-secondary" href="#">Больше достопримечательностей</a>
                </div>
            </section>
        </main>

        <footer class="footer d-flex align-items-center">
            <div class="container">
                <div class="footer__wrapper d-flex align-items-center justify-content-between">
                    <p>© Собери тур, 2024 г. Все пpава защищены</p>
                    <div class="footer__wrapper-policy d-flex flex-column flex-sm-row align-items-center gap-3">
                        <a href="#">Политика конфиденциальности</a>
                        <a href="#">Условия использования</a>
                    </div>
                </div>
            </div>
        </footer>

        <script src="<?php print TemplatesUtils::require_js("/build/common.bundle.js");?>"></script>

        </body>
        </html>

        <?php
    }
}