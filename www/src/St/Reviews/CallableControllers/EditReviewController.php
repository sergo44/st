<?php

namespace St\Reviews\CallableControllers;

use Override;
use St\ApplicationError;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Result;
use St\Review;
use St\Reviews\Views\EditReview\EditReviewHtmlView;
use St\Views\IView;

class EditReviewController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return EditReviewHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер редактирования объекта
     * @throws HttpError404Exception
     * @throws ApplicationError
     * @throws HttpError403Exception
     */
    public function index(int $review_id, ): EditReviewController
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

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}