<?php

namespace St\Sights\CallableControllers;

use St\BreadCrumbs;
use St\BreadCrumbsItem;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\Result;

class ShowSightsController extends CallableController implements ICallableController
{
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


        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}