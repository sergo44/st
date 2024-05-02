<?php

namespace St\Layouts\Site\CommonHtmlWidgets;

use St\Views\HtmlView;

class RestoreAccessHtmlWidget extends HtmlView
{
    public function out(): void
    {
        ?>

        <!------------------------------------------Форма восстановления----------------------------------------------------->
        <div aria-hidden="true" aria-labelledby="exampleModalToggleLabel" class="modal fade" id="restoreForm" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered overflow-x-hidden">
                <div class="modal-content modal-content-form modal-content-form-entry position-relative d-flex">
                    <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal" type="button"></button>
                    <div class="wrapper-modal-content wrapper-modal-content-restore flex-shrink-0">
                        <div class="modal-header flex-column gap-5 align-items-start">
                            <div class="wrapper-back-button d-flex align-items-center gap-2">
                                <div class="wrapper-arrow d-flex align-items-center">
                                    <img alt="" src="/images/icons/arrow-left.svg">
                                </div>
                                <button class="back-button" data-bs-target="#entryForm" data-bs-toggle="modal" type="button">Назад</button>
                            </div>
                            <h5 class="modal-title" id="restoreModalToggleLabel">Восстановление доступа к аккаунту</h5>

                        </div>
                        <div class="modal-body">
                            <form class="entry-form">
                                <div class="mb-5">
                                    <label class="form-label" for="restoreEmail">Введите адрес электронной почты <span>*</span></label>
                                    <input aria-describedby="emailHelp" class="form-control" id="restoreEmail" placeholder="example@gmail.com"
                                           required type="email">
                                    <div class="form-text" id="emailHelp"></div>
                                </div>


                                <button class="btn btn-warning w-100 mt-4" type="submit">Восстановить</button>
                            </form>
                            <div class="entry-form__socials">
                                <div class="email-shipped">
                                    <p>На указанный адрес электронной почты отправлено письмо с инструкциями по созданию нового пароля.</p>
                                    <p>Если вы не видите письма во входящих, проверьте папку со спамом.</p>
                                </div>
                                <div class="btn btn-outline-secondary mb-5">Отправить письмо повторно</div>
                                <div class="have-no-account d-flex align-items-center justify-content-center gap-3">
                                    <a href="#" class="mt-0 mb-0 link-warning entry-link" data-bs-target="#entryForm" data-bs-toggle="modal">Войти</a> или <a class="link-warning reg-link" onclick="event.preventDefault()" data-bs-target="#regForm" data-bs-toggle="modal" href="#">Зарегистрироваться</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-------------------------------------------Конец формы восстановления ----------------------------------------------------->

        <?php
    }
}