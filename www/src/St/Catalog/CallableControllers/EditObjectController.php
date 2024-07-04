<?php
/**
 * Контроллер редактирования объекта
 */
namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\Views\EditObject\EditObjectHtmlView;
use St\CatalogObject;
use St\Countries\GetVisibleCountries;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Result;
use St\Strings;
use St\Views\IView;

class EditObjectController extends UserCallableController implements ICallableController
{
    /**
     * Метод используется для явного указания типа вида
     * @return EditObjectHtmlView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер страницы редактирования объекта
     * @param int $object_id
     * @return EditObjectController
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     * @throws ApplicationError
     */
    public function index(int $object_id): EditObjectController
    {
        try {

            $object = CatalogObject::get($object_id);
            if (!$object->getObjectId()) {
                throw new HttpError404Exception(sprintf("Объект с идентификатором %s не найден", $object_id));
            }

            if ($this->getUser()?->getUserId() !== $object->getUserId()) {
                throw new HttpError403Exception(sprintf("Попытка редактировать объект %u, который принадлежит пользователю %u от имени пользователя %u", $object->getObjectId(), $object->getUserId(), $this->getUser()?->getUserId()));
            }

            $result = new Result();

            $this->getView()
                ->setResult($result)
                ->setCountriesList((new GetVisibleCountries())->getCountries())
                ->setCatalogObject($object)
            ;

            $this->getLayout()
                ->addJs("/build/add_object.bundle.js")
                ->setSectionTitle(sprintf("Редактирование объекта \"%s\"", Strings::escape($object->getName())));


        } catch (CallableControllerException $e) {

        }

        return $this;
    }
}