<?php

namespace St\Layouts\Site\CommonHtmlWidgets;

use St\Views\HtmlView;

class RegisterFormHtmlWidget extends HtmlView
{
    public function out(): void
    {
        ?>

        <!------------------------------------------Форма Регистрации----------------------------------------------------->
        <div aria-hidden="true" aria-labelledby="exampleModalToggleLabel" class="modal fade" id="regForm" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content modal-content-form modal-content-reg-form position-relative">
                    <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal" type="button"></button>
                    <div class="wrapper-modal-content-register d-grid flex-shrink-0">
                        <div class="modal-header modal-header-reg">
                            <h5 class="modal-title" id="regModalToggleLabel">Зарегистрируйтесь, чтобы добавлять отзывы и объекты</h5>
                        </div>
                        <div class="modal-body">
                            <form class="entry-form" method="post" action="/User/Register/Go" id="jsRegisterForm">
                                <div class="mb-5">
                                    <label class="form-label" for="regName">Введите Имя <span>*</span></label>
                                    <input aria-describedby="nameHelp" class="form-control" id="regName" placeholder="Имя" type="text" name="name">
                                    <div class="form-text" id="regNameHelp"></div>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label" for="regLogin">Введите Логин <span>*</span></label>
                                    <input aria-describedby="loginHelp" class="form-control" id="regLogin" placeholder="Логин" type="text" name="login">
                                    <div class="form-text" id="regLoginHelp"></div>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label" for="regPhone">Введите номер телефона <span>*</span></label>
                                    <input aria-describedby="loginHelp" class="form-control" id="regPhone" placeholder="Номер телефона" type="number" name="phone">
                                    <div class="form-text" id="regPhoneHelp"></div>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label" for="entryEmail">Введите адрес электронной почты <span>*</span></label>
                                    <input aria-describedby="emailHelp" class="form-control" id="regEmail" placeholder="example@gmail.com"  type="email" name="email">
                                    <div class="form-text" id="regEmailHelp"></div>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label" for="regInputPassword">Пароль <span>*</span></label>
                                    <div class="wrapper-password-input">
                                        <div class="wrapper-eye wrapper-crossed-eye">
                                            <img alt="" src="/images/icons/crossed-eye.svg">
                                        </div>
                                        <div class="wrapper-eye wrapper-not-crossed-eye">
                                            <img alt="" src="/images/icons/eye.svg">
                                        </div>
                                        <input class="form-control" id="regInputPassword" placeholder="Пароль" type="password" name="password">
                                        <div class="form-text" id="regPasswordHelp"></div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="regInputPasswordConfirm">Пароль (еще раз)<span>*</span></label>
                                    <div class="wrapper-password-input">
                                        <div class="wrapper-eye wrapper-crossed-eye">
                                            <img alt="" src="/images/icons/crossed-eye.svg">
                                        </div>
                                        <div class="wrapper-eye wrapper-not-crossed-eye">
                                            <img alt="" src="/images/icons/eye.svg">
                                        </div>
                                        <input class="form-control" id="regInputPasswordConfirm" placeholder="Пароль (еще раз)" type="password" name="password_confirm">
                                    </div>
                                </div>
                                <button class="btn btn-warning w-100 mt-4" type="submit">Зарегистрироваться</button>
                            </form>
                            <p>Или зарегистрируйтесь с помощью других сервисов</p>
                            <div class="entry-form__socials row justify-content-center gap-5">
                                <a class="google-link col-auto" href="google.com">
                                    <img alt="" src="/images/icons/Google.svg">
                                </a>
                                <a class="vk-link col-auto" href="vk.com">
                                    <img alt="" src="/images/icons/VK.svg">
                                </a>
                                <a class="ok-link col-auto" href="ok.ru">
                                    <img alt="" src="/images/icons/ok.svg">
                                </a>
                                <p class="policy">Авторизируясь, вы соглашаетесь <br>
                                    с <a href="#">Политикой конфиденциальности</a> и <a href="#">Условиями использования</a>
                                </p>
                                <div class="have-no-account d-flex align-items-center justify-content-center gap-3">
                                    <p class="mt-0 mb-0">Уже зарегистрированы?</p><a class="link-warning reg-entry-link" onclick="event.preventDefault()"  data-bs-target="#entryForm" data-bs-toggle="modal" href="#">Войти</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-------------------------------------------Конец формы входа ----------------------------------------------------->

        <?php
    }
}