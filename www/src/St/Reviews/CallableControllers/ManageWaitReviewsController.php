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
use St\Reviews\EditReview;
use St\Reviews\Views\WaitReviews\ApproveReviewHtmlStatusView;
use St\Reviews\Views\WaitReviews\DeclineReviewHtmlView;
use St\ReviewStatusesEnum;
use St\Views\IView;

class ManageWaitReviewsController extends UserCallableController implements ICallableController
{
    /**
     * Возвращает вид
     * @return ApproveReviewHtmlStatusView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }


    /**
     * Одобряет отзыв
     * @param int $review_id
     * @return ManageWaitReviewsController
     * @throws ApplicationError
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     */
    public function approve(int $review_id): ManageWaitReviewsController
    {
        return $this->change($review_id, ReviewStatusesEnum::Approved);
    }

    /**
     * Отклонят отзыв
     * @param int $review_id
     * @return ManageWaitReviewsController
     * @throws ApplicationError
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     */
    public function decline(int $review_id): ManageWaitReviewsController
    {
        return $this->change($review_id, ReviewStatusesEnum::Approved);
    }

    /**
     * Изменяет статус объекта отзыва
     * @param int $review_id
     * @param ReviewStatusesEnum $statuses_enum
     * @return ManageWaitReviewsController
     * @throws ApplicationError
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     */
    public function change(int $review_id, ReviewStatusesEnum $statuses_enum): ManageWaitReviewsController
    {
        $this->getView()
            ->setResult( $result = new Result() )
            ;

        $this->getLayout()
            ->setSectionTitle("Обновление отзыва")
            ;

        try {

            if (!$this->getUser()->getUserRoleHelper()->canModerationObjects()) {
                throw new HttpError403Exception("У вас недостаточно прав для доступа к данному разделу");
            }

            $review = Review::get($review_id);
            if (!$review) {
                throw new HttpError404Exception(sprintf("Отзыв с идентификатором %u не найден", $review_id));
            }

            $this->getView()
                ->setReview($review);

            $review
                ->setStatus($statuses_enum->name)
            ;

            $store = new EditReview($review);
            $store->save();


        } catch(CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }


}