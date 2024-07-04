<?php

namespace St\Reviews\CallableControllers;

use St\ApplicationError;
use St\DateTimeHelper;
use St\Db;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\Review;
use St\Reviews\AddReview;

class AddReviewController extends UserCallableController implements ICallableController
{
    /**
     * Метод контроллера добавления отзыва
     * @throws ApplicationError
     */
    public function index(int $object_id): AddReviewController
    {
        $this->getView()
            ->setResult($result = new Result())
        ;

        try {

            $review = new Review();
            $review
                ->setUserId($this->getUser()->getUserId())
                ->setObjectId($object_id)
                ->setPublishDatetimeUtc(DateTimeHelper::now()->format("Y-m-d H:i:s"))
                ->setRestPeriod($this->getUserInputData("rest_period", 255) ?: "")
                ->setMark((int)$this->getUserInputData("mark"))
                ->setReviewText($this->getUserInputData("review_text", 65535) ?: "")
            ;

            $add_review = new AddReview(Db::getWritePDOInstance(), $review);
            $add_review->check($result);

            if ($result->isSuccess()) {
                $add_review->saveToDb();
            }

        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }
        return $this;
    }
}