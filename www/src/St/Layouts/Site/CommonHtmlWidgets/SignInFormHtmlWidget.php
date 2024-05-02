<?php

namespace St\Layouts\Site\CommonHtmlWidgets;

use St\Views\HtmlView;

class SignInFormHtmlWidget extends HtmlView
{
    public function out(): void
    {
        ?>

        <!------------------------------------------Форма входа----------------------------------------------------->
        <div aria-hidden="true" aria-labelledby="exampleModalToggleLabel" class="modal fade" id="entryForm" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered overflow-x-hidden">

                <div class="modal-content modal-content-form modal-content-form-entry position-relative d-flex">
                    <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal" type="button"></button>
                    <div class="wrapper-modal-content wrapper-modal-content-entry flex-shrink-0">
                        <div class="modal-header">
                            <h5 class="modal-title" id="entryModalToggleLabel">Вход в личный кабинет</h5>
                        </div>
                        <div class="modal-body">
                            <form class="entry-form" action="/User/SignIn/Go" method="post" id="jsSignInForm">
                                <div class="mb-5">
                                    <label class="form-label" for="entryEmail">Введите адрес электронной почты или логин <span>*</span></label>
                                    <input aria-describedby="emailHelp" class="form-control" id="entryEmail" placeholder="example@gmail.com" required name="login">
                                    <div class="form-text" id="entryEmailHelp"></div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label" for="inputPassword">Пароль <span>*</span></label>
                                    <div class="wrapper-password-input">
                                        <div class="wrapper-eye wrapper-crossed-eye">
                                            <img alt="" src="/images/icons/crossed-eye.svg">
                                        </div>
                                        <div class="wrapper-eye wrapper-not-crossed-eye">
                                            <img alt="" src="/images/icons/eye.svg">
                                        </div>
                                        <input class="form-control" id="inputPassword" placeholder="Пароль" required name="password" type="password">
                                    </div>
                                </div>
                                <a class="link-warning lost-password" data-bs-target="#restoreForm" data-bs-toggle="modal" href="#">Забыли пароль?</a>
                                <button class="btn btn-warning w-100 mt-4" type="submit">Войти</button>
                            </form>
                            <p>Или войдите с помощью других сервисов</p>
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
                                    <p class="mt-0 mb-0">Еще нет аккаунта?</p><a class="link-warning reg-link" onclick="event.preventDefault()" data-bs-target="#regForm" data-bs-toggle="modal" href="#">Зарегистрироваться</a>
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