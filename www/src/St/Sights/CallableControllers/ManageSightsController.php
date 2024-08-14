<?php

namespace St\Sights\CallableControllers;

use Override;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\Sights\Sight;
use St\Sights\SightStatusEnum;
use St\Sights\SightStore;
use St\Sights\Views\WaitSights\ManageSightHtmlView;
use St\Views\IView;

class ManageSightsController extends UserCallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return ManageSightHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Одобрение достопримечательности
     * @param int $sight_id
     * @return $this
     */
    public function approve(int $sight_id, SightStatusEnum $status_enum): ManageSightsController
    {

        $this->getView()
            ->setResult( $result = new Result() )
        ;

        $this->getLayout()
            ->setSectionTitle("Управление достопримечательностями")
            ;

        try {

            $sight = Sight::get($sight_id);
            if (!$sight) {
                throw new CallableControllerException("Достопримечательность не найдена");
            }

            $this->getView()
                ->setSight($sight)
                ;

            if ($sight->getStatusEnum() !== SightStatusEnum::Wait) {
                throw new CallableControllerException("Неверный статус объекта");
            }

            $sight
                ->setStatus($status_enum->name)
            ;

            $store = new SightStore($sight);
            $store->update();


        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}