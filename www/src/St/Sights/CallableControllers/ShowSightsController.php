<?php

namespace St\Sights\CallableControllers;

use St\BreadCrumbs;
use St\BreadCrumbsItem;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\Result;
use St\Sights\GetVisibleSights;
use St\Sights\Views\ShowSights\ShowSightsHtmlView;
use St\Views\IView;

class ShowSightsController extends CallableController implements ICallableController
{
    /**
     * @inheritdoc
     * @return ShowSightsHtmlView
     */
    public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер
     * @return $this
     */
    public function index(): ShowSightsController
    {

        $this->getView()
            ->setResult( $result = new Result() )
        ;

        try {

            $this->getLayout()
                ->setSectionTitle("Достопримечательности")
            ;

            BreadCrumbs::getInstance()
                ->add( new BreadCrumbsItem("Достопримечательности", "/Sights/Show") )
            ;

            $this->getView()
                ->setSights( (new GetVisibleSights())->GetSights() )
            ;

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}