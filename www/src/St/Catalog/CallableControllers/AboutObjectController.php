<?php

namespace St\Catalog\CallableControllers;

use St\Catalog\Views\AboutObject\AboutObjectHtmlView;
use St\CatalogObject;
use St\FrontController\CallableController;
use St\FrontController\ICallableController;
use St\HttpError404Exception;
use St\Views\IView;

class AboutObjectController extends CallableController implements ICallableController
{
    /**
     * Возвращает вид (для IDE)
     * @return AboutObjectHtmlView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер отображения информации об объекте
     * @param int $object_id
     * @return ICallableController
     * @throws HttpError404Exception
     */
    public function index(int $object_id): ICallableController
    {
        $catalog_object = CatalogObject::get($object_id);

        if (!$catalog_object->getObjectId()) {
            throw new HttpError404Exception(sprintf("Object with id %u not found", $object_id));
        }

        $this->getView()->setCatalogObject($catalog_object);
        $this->getLayout()->setSectionTitle($this->getView()->escape($catalog_object->getName()));

        return $this;
    }
}