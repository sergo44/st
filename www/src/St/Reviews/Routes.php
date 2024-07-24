<?php
/**
 * Файл маршрутизации модуля отзывов
 * @since 1.0.5
 * @author Sergey A Oskorbin
 * @package Review
 */

namespace St\Reviews;

use St\ApplicationError;
use St\FrontController\FileRoute;
use St\FrontController\ICallableController;
use St\FrontController\IRoute;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Layouts\JsonLayout;
use St\Layouts\Site\UserHtmlLayout;
use St\Reviews;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизация модуля отзывов
     * @throws HttpError403Exception
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#^/?Reviews/Add/([1-9]+[0-9]*)/Go/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\AddReviewController($_REQUEST, new JsonLayout(), new Views\AddReview\AddReviewGoJsonView()))->index($match[1]);
        }

        if (preg_match("#^/?Reviews/Wait/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\ListWaitReviewsController($_REQUEST, new UserHtmlLayout(), new Views\WaitReviews\ListWaitReviewsHtmlView()))->index();
        }

        if (preg_match("#^/?Reviews/([1-9][0-9]*)/Approve/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\ManageWaitReviewsController($_REQUEST, new UserHtmlLayout(), new Views\WaitReviews\ApproveReviewHtmlStatusView()))->approve((int)$match[1]);
        }
        if (preg_match("#^/?Api/Reviews/([1-9][0-9]*)/Approve/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\ManageWaitReviewsController($_REQUEST, new JsonLayout(), new Views\WaitReviews\ApproveReviewJsonView()))->approve((int)$match[1]);
        }

        if (preg_match("#^/?Reviews/([1-9][0-9]*)/Decline/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\ManageWaitReviewsController($_REQUEST, new UserHtmlLayout(), new Views\WaitReviews\ApproveReviewHtmlStatusView()))->decline((int)$match[1]);
        }

        if (preg_match("#^/?Api/Reviews/([1-9][0-9]*)/Decline/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\ManageWaitReviewsController($_REQUEST, new JsonLayout(), new Views\WaitReviews\DeclineReviewJsonView()))->decline((int)$match[1]);
        }

        if (preg_match("#^/?Reviews/([1-9][0-9]*)/Edit/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\EditReviewController($_REQUEST, new UserHtmlLayout(), new Views\EditReview\EditReviewHtmlView()))->index((int)$match[1]);
        }

        if (preg_match("#^/?Reviews/([1-9][0-9]*)/Edit/Go/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\EditReviewGoController($_REQUEST, new UserHtmlLayout(), new Views\EditReview\EditReviewGoHtmlView()))->index((int)$match[1]);
        }

        return null;
    }
}