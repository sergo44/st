<?php

namespace St\Catalog\CallableControllers;

use Override;
use St\ApplicationError;
use St\Catalog\EditObject;
use St\Catalog\Views\ManageObjects\IManageObjectsView;
use St\CatalogObject;
use St\CatalogObjectsStatusesEnum;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\Views\IView;

class ManageObjectsController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return IManageObjectsView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }


    /**
     * Одобряет объект
     * @throws ApplicationError
     */
    public function approve(int $object_id): ManageObjectsController
    {
        return $this->change($object_id, CatalogObjectsStatusesEnum::Approved);
    }

    /**
     * Блокирование объекта
     * @param int $object_id
     * @return $this
     * @throws ApplicationError
     */
    public function decline(int $object_id): ManageObjectsController
    {
        return $this->change($object_id, CatalogObjectsStatusesEnum::Decline);
    }

    /**
     * Метод обновление статуса объекта
     * @param int $object_id
     * @param CatalogObjectsStatusesEnum $objects_statuses_enum
     * @return ManageObjectsController
     * @throws ApplicationError
     */
    public function change(int $object_id, CatalogObjectsStatusesEnum $objects_statuses_enum): ManageObjectsController
    {
        $this->getView()
            ->setResult( $result = new Result() )
        ;

        $this->getLayout()
            ->setSectionTitle("Управление объектами")
        ;

        try {

            if (!$this->getUser()->getUserRoleHelper()->canModerationObjects()) {
                throw new CallableControllerException("У вас недостаточно прав для доступа к данному разделу");
            }

            $object = CatalogObject::get($object_id);
            if (!$object->getObjectId()) {
                throw new CallableControllerException("Объект не найден");
            }

            $this->getView()
                ->setObject($object)
            ;

            $object
                ->setStatus($objects_statuses_enum->name)
                ->setProcessedUserId($this->getUser()->getUserId())
            ;

            $store = new EditObject($object);
            $store->update();


        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }
}