<?php

namespace St\User\Views\Account;

use St\ApplicationError;
use St\Auth;use St\Views\HtmlView;
use St\Views\IView;

class AccountIndexHtmlView extends HtmlView implements IView
{
    /**
     * Выводит шаблон информации об аккаунте
     * @throws ApplicationError
     */
    public function out(): void
    {
        ?>

        <!-- <div class="attention-block attention-error position-relative mt-5 hidden">
                            <div class="hidden attention-title-block d-flex align-items-center justify-content-between">
                                <div class="attention-title d-flex align-items-center gap-2">
                                    <div class="wrapper-attention-icon">
                                        <img alt="" src="/images/icons/attention-error.svg">
                                    </div>
                                    ВНИМАНИЕ
                                </div>
                                <button aria-label="Close" class="btn-close position-absolute" data-bs-dismiss="modal"
                                        type="button"></button>
                            </div>
                            <div class="section-profile__confirm-email ps-4 mt-3">Подтвердите адрес вашей электронной почты, чтобы
                                оставлять отзывы и добавлять объекты.
                            </div>
                            <a class="link-warning d-flex justify-content-end mt-3" href="#">Подтвердить</a>
                        </div> -->

        <div class="section-profile__wrapper-block">
            <div class="section-profile__inputs">

                <form class="entry-form mt-5">
                    <div class="section-profile__one-block">
                        <h5>Личная информация</h5>
                        <div class="section-profile__wrapper-inputs d-flex gap-5">
                            <div class="mb-5 flex-grow-1">
                                <label class="form-label" for="profileName">Имя</label>
                                <input aria-describedby="emailHelp" class="form-control" id="profileName" placeholder="Имя"
                                       value="<?php print $this->escape(Auth::getInstance()->get()->getName()); ?>"
                                       required type="text">
                            </div>
                            <div class="mb-5 flex-grow-1">
                                <label class="form-label" for="profileLogin">Логин</label>
                                <div class="wrapper-password-input">
                                    <input class="form-control" id="profileLogin"
                                           placeholder="Логин"
                                           required type="text"
                                           value="<?php print $this->escape(Auth::getInstance()->get()->getLogin()); ?>"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-profile__one-block">
                        <h5>Контакты</h5>
                        <div class="section-profile__wrapper-inputs d-flex gap-5">
                            <div class="mb-5 flex-grow-1">
                                <label class="form-label" for="profilePhone">Телефон</label>
                                <input aria-describedby="emailHelp" class="form-control" id="profilePhone"
                                       value="<?php print $this->escape(Auth::getInstance()->get()->getPhone()); ?>"
                                       placeholder="+7 (999) 999-99-99"
                                       required="" type="tel" readonly>
                            </div>
                            <div class="mb-5 flex-grow-1">
                                <label class="form-label" for="profileEmail">Адрес электронной почты</label>
                                <div class="wrapper-password-input">
                                    <input class="form-control" id="profileEmail" placeholder="example@example.ru" required
                                           value="<?php print $this->escape(Auth::getInstance()->get()->getEmail()); ?>"
                                           readonly
                                           type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-profile__one-block">
                        <h5>Дополнительные сведения</h5>
                        <div class="section-profile__wrapper-inputs additional d-grid gap-5">
                            <div class="mb-5">
                                <label class="form-label" for="clockBelt">Часовой пояс</label>
                                <input class="form-control" id="clockBelt" placeholder="UTC +2"
                                       required="" type="tel">
                            </div>
                        </div>
                    </div>
                    <div class="section-profile__settings-block">
                        <h5>Настройка уведомлений</h5>
                        <ul class="section-catalog__filter-items section-profile__settings mt-4">
                            <li class="d-flex align-items-center gap-3">
                                <input class="flex-shrink-0" id="filterItem-1" name="" type="checkbox">
                                <label for="filterItem-1">Отправлять уведомления на номер телефона</label>
                            </li>
                            <li class="d-flex align-items-center gap-3">
                                <input class="flex-shrink-0" id="filterItem-2" name="" type="checkbox">
                                <label for="filterItem-2">Отправлять уведомления на адрес электронной почты </label>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-warning col-auto mt-5" role="button" type="submit">Сохранить изменения</button>
                </form>
                <form action="" class="entry-form mt-5">
                    <div class="section-profile__one-block">
                        <h5>Безопасность</h5>
                        <div class="additional d-grid gap-5">
                            <div class="mb-2">
                                <label class="form-label" for="profilePassword">Пароль</label>
                                <div class="wrapper-password-input">
                                    <div class="wrapper-eye wrapper-crossed-eye">
                                        <img alt="" src="/images/icons/crossed-eye.svg">
                                    </div>
                                    <div class="wrapper-eye wrapper-not-crossed-eye">
                                        <img alt="" src="/images/icons/eye.svg">
                                    </div>
                                    <input class="form-control" id="profilePassword" placeholder="Пароль" required=""
                                           type="password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-warning col-auto mt-5" role="button" type="submit">Изменить пароль</button>
                </form>
            </div>
        </div>

        <?php
    }
}