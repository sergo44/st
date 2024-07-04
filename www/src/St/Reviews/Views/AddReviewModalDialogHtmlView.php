<?php

namespace St\Reviews\Views;

use St\CatalogObject;
use St\User;
use St\Views\HtmlView;
use St\Views\IView;

class AddReviewModalDialogHtmlView extends HtmlView implements IView
{
    /**
     * Пользователь, для которого выводим модальный диалог добавления отзыва
     * @var User
     */
    protected User $user;
    /**
     * Объект каталога, к которому добавляется объект
     * @var CatalogObject
     */
    protected CatalogObject $catalog_object;

    /**
     * Конструктор вида модального диалога добавления изображения
     * @param User $user
     * @param CatalogObject $catalog_object
     */
    public function __construct(User $user, CatalogObject $catalog_object)
    {
        $this->user = $user;
        $this->catalog_object = $catalog_object;
    }

    /**
     * @inheritDoc
     * @return void
     */
    #[\Override] public function out(): void
    {
        ?>

        <!-- Modal -->
        <div class="modal modal-lg fade" id="jsAddReviewModal" tabindex="-1" role="dialog" aria-labelledby="jsAddReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="/Reviews/Add/<?php print $this->catalog_object->getObjectId(); ?>/Go" method="post" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="jsAddReviewModalLabel">Добавление отзыва</h4>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-wrap">
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="restPeriodInputForm">Период отдыха<span>*</span></label>
                                    <input type="text" class="form-control" name="rest_period" id="restPeriodInputForm" value="" placeholder="Например: Илью 2024 года" maxlength="255">
                                </div>
                                <div class="mb-1 position-relative wrapper-services-input w-100">
                                    <label class="form-label" for="orderRoomInputEmail">Ваша оценка <span>*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="mark" value="1" title="Оценка 1"/> 1
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="mark" value="2" title="Оценка 2"/> 2
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="mark" value="3" title="Оценка 3"/> 3
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="mark" value="4" title="Оценка 4"/> 4
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" name="mark" value="5" title="Оценка 4"/> 5
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap w-100">
                                    <div class="mb-0 mb-sm-5 position-relative wrapper-services-input w-100">
                                        <label class="form-label" for="reviewRemarkInputForm">Ваш отзыв</label>
                                        <textarea class="form-control input-services-list h-100 w-100" name="review_text" id="reviewRemarkInputForm" type="text"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-warning">Добавить отзыв</button>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" value="<?php print $this->escape($this->user->getUserId())?>">
                    <input type="hidden" name="object_id" value="<?php print $this->escape($this->catalog_object->getObjectId())?>">
                </form>
            </div>
        </div>

        <?php
    }


}