<?php

namespace St\Reviews\CallableControllers;

use St\ApplicationError;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Result;
use St\Review;
use St\Reviews\ReviewStore;
use St\Reviews\Views\EditReview\EditReviewGoHtmlView;
use St\ReviewStatusesEnum;
use St\Views\IView;

class EditReviewGoController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return EditReviewGoHtmlView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер редактирования объекта
     * @return $this
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     * @throws ApplicationError
     */
    public function index(int $review_id): EditReviewGoController
    {
        $this->getView()
            ->setResult( $result = new Result() )
        ;

        $this->getLayout()
            ->setSectionTitle("Редактирование отзыва")
        ;

        try {

            $review = Review::get($review_id);
            if (!$review?->getReviewId()) {
                throw new HttpError404Exception(sprintf("Указанный вами отзыв (id: %u) не найден", $review_id));
            }

            if  (
                !$this->getUser()->getUserRoleHelper()->canModerationObjects()
                && $review->getUserId() !== $this->getUser()->getUserId()
            ) {
                throw new HttpError403Exception(sprintf("У пользователя с id %u отсутствует доступ к редактированию отзыва %u", $this->getUser()->getUserId(), $review->getReviewId()));
            }

            $this->getView()
                ->setReview($review)
                ->setCanSetStatus( $this->getUser()->getUserRoleHelper()->canModerationObjects() )
            ;

            $review
                ->setRestPeriod($this->getUserInputData("rest_period", 0xff) ?? "" )
                ->setMark(max(1, min(5, (int)$this->getUserInputData("mark"))))
                ->setReviewText($this->getUserInputData("review_text", 0xffff) ?? "")
            ;

            if ($this->getUser()->getUserRoleHelper()->canModerationObjects()) {

                $status = $this->getUserInputData("status", 255);

                if ($status) {

                    if (!defined(ReviewStatusesEnum::class . "::" . $status)) {
                        throw new CallableControllerException("Неизвестный статус отзыва");
                    }

                    $review
                        ->setStatus($status)
                    ;
                }
            }

            $store = new ReviewStore($review);
            $store->check($result);

            if ($result->isSuccess()) {

                $store->update();

                $unlink_images = $this->getUserInputData("unlink_image");
                if (is_array($unlink_images) && sizeof($unlink_images)) {
                    foreach ($unlink_images as $review_image_id) {
                        $store->removeImageUsingPrimaryKey((int)$review_image_id);
                    }
                }

                $this->getView()
                    ->setEdited(true)
                ;
            }

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}