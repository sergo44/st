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
use St\Layouts\JsonLayout;
use St\Reviews;

class Routes extends FileRoute implements IRoute
{

    /**
     * Маршрутизация модуля отзывов
     * @throws HttpError403Exception
     * @throws ApplicationError
     */
    #[\Override] public function tryRoute(): ICallableController|null
    {
        if (preg_match("#^/?Reviews/Add/([1-9]+[0-9]*)/Go/?$#ui", $this->dispatcher->getPath(), $match)) {
            return (new Reviews\CallableControllers\AddReviewController($_REQUEST, new JsonLayout(), new Views\AddReview\AddReviewGoJsonView()))->index($match[1]);
        }

        return null;
    }
}