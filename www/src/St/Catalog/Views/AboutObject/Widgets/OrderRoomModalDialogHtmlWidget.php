<?php

namespace St\Catalog\Views\AboutObject\Widgets;

use St\User;
use St\Views\HtmlView;
use St\Views\IView;

class OrderRoomModalDialogHtmlWidget extends HtmlView implements IView
{
    /**
     * Пользователь, для которого отображаем форму
     * @var User|null
     */
    protected ?User $user;

    public function __construct(?User $user)
    {
        $this->user = $user;
    }

    #[\Override] public function out(): void
    {
        ?>

        <!-- Modal -->
        <div class="modal fade modal-lg" id="jsOrderRoomModal" tabindex="-1" role="dialog" aria-labelledby="jsOrderRoomModalTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/Catalog/Objects/Room/Book/Go" method="post" class="form-horizontal" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title" id="jsOrderRoomModalTitle">Забронировать номер</h4>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">Пожалуйста, заполните заявку ниже и мы отправим ее администратору</div>
                            <div class="d-flex flex-wrap">
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="orderRoomInputName">Как вам обращаться? <span>*</span></label>
                                    <input type="text" class="form-control" name="name" id="orderRoomInputName" value="<?php print $this->escape($this->user?->getName());?>">
                                </div>
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="orderRoomInputEmail">Адрес электронной почты <span>*</span></label>
                                    <input type="text" class="form-control" name="email" id="orderRoomInputEmail" value="<?php print $this->escape($this->user?->getEmail());?>">
                                </div>
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="orderRoomInputPhone">Номер телефона для связи <span>*</span></label>
                                    <input type="text" class="form-control" name="phone" id="orderRoomInputPhone" value="<?php print $this->escape($this->user?->getPhone());?>">
                                </div>
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="orderRoomInputArrivalDate">Желаемая дата заезда <span>*</span></label>
                                    <input type="text" class="form-control" name="arrival_date" id="orderRoomInputArrivalDate" value="">
                                </div>
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="orderRoomInputDepartureDate">Желаемая дата выезда <span>*</span></label>
                                    <input type="text" class="form-control" name="departure_date" id="orderRoomInputDepartureDate" value="">
                                </div>
                                <div class="d-flex flex-wrap w-100">
                                    <div class="mb-0 mb-sm-5 position-relative wrapper-services-input w-100">
                                        <label class="form-label" for="orderRoomInputRemark">Ваши пожелания, вопросы или любая другая дополнительная информация</label>
                                        <textarea class="form-control input-services-list h-100 w-100" name="remark" id="orderRoomInputRemark" type="text"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-warning">Отправить заявку</button>
                        </div>

                        <input type="hidden" name="hotel_room_id" value="" />

                    </form>
                </div>
            </div>
        </div>

        <?php
    }


}