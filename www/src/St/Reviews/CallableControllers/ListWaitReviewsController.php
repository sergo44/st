<?php

namespace St\Reviews\CallableControllers;

use Override;
use St\ApplicationError;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\Result;
use St\Reviews\GetWaitReviews;
use St\Reviews\Views\WaitReviews\ListWaitReviewsHtmlView;
use St\Views\IView;

class ListWaitReviewsController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return ListWaitReviewsHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер управления отзывами
     * @throws HttpError403Exception
     * @throws ApplicationError
     */
    public function index(): ListWaitReviewsController
    {

        $this->getView()
            ->setResult( $result = new Result() )
        ;

        $this->getLayout()
            ->setSectionTitle("Модерация отзывов")
            ->addJs("/build/manage_wait_review.bundle.js")
        ;

        try {

            if (!$this->getUser()->getUserRoleHelper()->canModerationObjects()) {
                throw new HttpError403Exception("У вас не достаточно прав для доступа к данному разделу");
            }

            $this->getView()
                ->setReviews( (new GetWaitReviews())->getReviews() )
            ;

        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }
}