<?php

namespace St\Reviews\Views\EditReview;

use St\Review;
use St\ReviewStatusesEnum;
use St\Views\HtmlView;
use St\Views\IView;

class EditReviewHtmlView extends HtmlView implements IView
{
    /**
     * Признак, что объект успешно отредактирован
     * @var bool
     */
    protected bool $edited = false;
    /**
     * Отзыв
     * @var Review|null
     */
    protected ?Review $review = null;
    /**
     * Может ставить статус
     * @var bool
     */
    protected bool $can_set_status = false;
    /**
     * Свойство содержит признак, куда возвращается
     * в случае успешного редактирования отзыва
     * @var string
     */
    protected string $return_uri = "/Reviews/Wait";

    /**
     * Возвращает edited
     * @return bool
     * @see edited
     */
    public function isEdited(): bool
    {
        return $this->edited;
    }

    /**
     * Устанавливает edited
     * @param bool $edited
     * @return EditReviewHtmlView
     * @see edited
     */
    public function setEdited(bool $edited): EditReviewHtmlView
    {
        $this->edited = $edited;
        return $this;
    }

    /**
     * Возвращает review
     * @return Review|null
     * @see review
     */
    public function getReview(): ?Review
    {
        return $this->review;
    }

    /**
     * Устанавливает review
     * @param Review|null $review
     * @return EditReviewHtmlView
     * @see review
     */
    public function setReview(?Review $review): EditReviewHtmlView
    {
        $this->review = $review;
        return $this;
    }

    /**
     * Возвращает can_set_status
     * @return bool
     * @see can_set_status
     */
    public function getCanSetStatus(): bool
    {
        return $this->can_set_status;
    }

    /**
     * Устанавливает can_set_status
     * @param bool $can_set_status
     * @return EditReviewHtmlView
     * @see can_set_status
     */
    public function setCanSetStatus(bool $can_set_status): EditReviewHtmlView
    {
        $this->can_set_status = $can_set_status;
        return $this;
    }

    /**
     * Возвращает return_uri
     * @return string
     * @see return_uri
     */
    public function getReturnUri(): string
    {
        return $this->return_uri;
    }

    /**
     * Устанавливает return_uri
     * @param string $return_uri
     * @return EditReviewHtmlView
     * @see return_uri
     */
    public function setReturnUri(string $return_uri): EditReviewHtmlView
    {
        $this->return_uri = $return_uri;
        return $this;
    }

    /**
     * @inheritdoc
     * @return void
     */
    #[\Override] public function out(): void
    {
       ?>

        <?php if ($this->edited):?>

            <div class="alert alert-success">
                <h5>OK</h5>
                <p>Отзыв успешно сохранен!</p>
                <p><a href="<?php print $this->getReturnUri()?>">Вернуться назад</p>
            </div>

        <?php elseif($this->getReview()):?>

            <form action="/Reviews/<?php print $this->review->getReviewId() ?>/Edit/Go" method="post" enctype="multipart/form-data">
                <div class="d-flex flex-row gap-2 mb-2">
                    <?php foreach ($this->review->getImages() as $image):?>
                        <div class="d-flex flex-column ">
                            <div class="d-flex"><img src="<?php print $image->getUri(293, 158);?>" alt="Review image" style="border-radius: 3px"/></div>
                            <div class="d-flex justify-content-center m-2">
                                <input type="checkbox" class="checkbox" name="unlink_image[]" value="<?php print $image->getReviewImageId()?>" title="Удалить изображение">
                                <span class="ms-3"> Удалить</span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <div class="d-flex flex-wrap">
                    <div class="mb-3 position-relative wrapper-services-input w-100">
                        <label class="form-label" for="restPeriodInputForm">Период отдыха<span>*</span></label>
                        <input type="text" class="form-control" name="rest_period" id="restPeriodInputForm" placeholder="Например: Илью 2024 года" maxlength="255" value="<?php print $this->e($this->getReview()?->getRestPeriod())?>">
                    </div>

                    <div class="mb-1 position-relative wrapper-services-input w-100">
                        <label class="form-label" for="orderRoomInputEmail">Оценка <span>*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="mark" value="1" title="Оценка 1"<?php print $this->review->getMark() === 1 ? " checked" : null;?> /> 1
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="mark" value="2" title="Оценка 2"<?php print $this->review->getMark() === 2? " checked" : null;?> /> 2
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="mark" value="3" title="Оценка 3"<?php print $this->review->getMark() === 3? " checked" : null;?> /> 3
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="mark" value="4" title="Оценка 4"<?php print $this->review->getMark() === 4? " checked" : null;?> /> 4
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="mark" value="5" title="Оценка 5"<?php print $this->review->getMark() === 5? " checked" : null;?> /> 5
                            </div>
                        </div>

                    </div>
                    <?php if ($this->getCanSetStatus()):?>
                        <div class="mb-3 position-relative wrapper-services-input w-100">
                            <label class="form-label" for="reviewStatusSelect">Статус отзыва  <?php print $this->review->getStatus();?></label>
                            <select class="form-select" name="status" id="reviewStatusSelect">
                                <?php foreach (ReviewStatusesEnum::cases() as $case):?>
                                    <option value="<?php print $case->name?>"<?php print $case->name === $this->review->getStatus() ? " selected" : null?>><?php print $case->label()?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                    <div class="mb-3 d-flex flex-wrap w-100">
                        <div class="mb-0 mb-sm-5 position-relative wrapper-services-input w-100">
                            <label class="form-label" for="reviewRemarkInputForm">Отзыв</label>
                            <textarea class="form-control input-services-list h-250 w-100" name="review_text" id="reviewRemarkInputForm" type="text"><?php print $this->e($this->review->getReviewText())?></textarea>
                        </div>
                    </div>
                </div>
                <button class="btn btn-warning" type="submit">Сохранить изменения</button>
            </form>
        <?php endif; ?>



        <?php
    }


}