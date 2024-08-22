<?php

namespace St\Sights\CallableControllers;

use Override;
use St\BreadCrumbs;
use St\BreadCrumbsItem;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\HttpError404Exception;
use St\Result;
use St\Sights\Sight;
use St\Sights\Views\AboutSight\AboutSightHtmlView;
use St\Views\IView;

class AboutSightController extends CallableController implements ICallableController
{

    /**
     * Возвращает шаблон
     * @return AboutSightHtmlView
     */
    #[Override] public function getView(): IView
    {
        return parent::getView();
    }


    /**
     * Контроллер вывода
     * @param int $sight_id
     * @return $this
     * @throws HttpError404Exception
     */
    public function index(int $sight_id): AboutSightController
    {

        $this->getView()
            ->setResult( $result = new Result() )
        ;

        try {

            $sight = Sight::get($sight_id);
            if (!$sight) {
                throw new HttpError404Exception("Достопримечательность с идентификатором %s не найдена", $sight_id);
            }

            $this->getLayout()
                ->setSectionTitle($sight->getName())
                ->addJs("/build/about_sight.bundle.js")
            ;

            $this->getView()
                ->setSight($sight)
            ;

            BreadCrumbs::getInstance()
                ->add( new BreadCrumbsItem($sight->getName(), $sight->getAboutUrl()) )
            ;

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}