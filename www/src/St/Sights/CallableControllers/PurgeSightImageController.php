<?php

namespace St\Sights\CallableControllers;

use St\ApplicationError;
use St\Catalog\CallableControllers\PurgeObjectImageController;
use St\Catalog\PurgeObjectImage;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError404Exception;
use St\Result;
use St\Sights\PurgeSightImage;
use St\Sights\Sight;

class PurgeSightImageController extends UserCallableController implements ICallableController
{
    /**
     * @throws HttpError404Exception
     * @throws ApplicationError
     */
    public function index(int $sight_id, int $image_id): PurgeSightImageController
    {
        $this->getView()
            ->setResult( $result = new Result() );

        try {

            $sight = Sight::get($sight_id);

            if (!$sight) {
                throw new HttpError404Exception(sprintf("Достопримечательность с указанным идентификатором [%u] не найдена", $sight_id));
            }

            if (
                !$this->getUser()->getUserRoleHelper()->canModerationObjects()
                && $this->getUser()->getUserId() !== $sight->getUserId()
            ) {
                throw new HttpError404Exception(sprintf("У пользователя с id [%u] нет доступа к редактированию достопримечательности с id [%u]", $this->getUser()->getUserId(), $sight->getSightId()));
            }

            $found_image = false;

            foreach ($sight->getImages() as $image) {
                if ($image->getSightImageId() === $image_id) {
                    $found_image = true;
                    (new PurgeSightImage($image))->purge();
                }
            }

            if (!$found_image) {
                throw new CallableControllerException("Указанное изображение не найдено. Возможно данные устарели");
            }

        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }
}