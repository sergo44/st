<?php

namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\PurgeObjectImage;
use St\CatalogObject;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Result;

class PurgeObjectImageController extends UserCallableController implements ICallableController
{
    /**
     * Контроллер удаления изображений из объектов
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     * @throws ApplicationError
     */
    public function index(int $object_id, int $image_id): PurgeObjectImageController
    {
        $this->getView()->setResult( $result = new Result() );

        try {

            $object = CatalogObject::get($object_id);
            if (!$object->getObjectId()) {
                throw new HttpError404Exception(sprintf("Объект с идентификатором %s не найден", $object_id));
            }

            if ($this->getUser()?->getUserId() !== $object->getUserId()) {
                throw new HttpError403Exception(sprintf("Попытка редактировать объект %u, который принадлежит пользователю %u от имени пользователя %u", $object->getObjectId(), $object->getUserId(), $this->getUser()?->getUserId()));
            }

            $found_image = false;

            foreach ($object->getImages() as $image) {
                if ($image->getImageId() === $image_id) {
                    $found_image = true;
                    (new PurgeObjectImage($image))->purge($result);
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