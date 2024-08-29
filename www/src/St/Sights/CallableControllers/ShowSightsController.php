<?php

namespace St\Sights\CallableControllers;

use St\ApplicationError;
use St\BreadCrumbs;
use St\BreadCrumbsItem;
use St\Cities\GetAllCities;
use St\City;
use St\Countries\CountriesEnumHelper;
use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\HttpError404Exception;
use St\Region;
use St\Regions\GetCountryRegions;
use St\Result;
use St\Sights\GetVisibleSights;
use St\Sights\SightFilter;
use St\Sights\Views\ShowSights\ShowSightsHtmlView;
use St\Sights\Views\SightFilterHtmlView;
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
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    public function index($city_id = null): ShowSightsController
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

            if ($city_id) {

                $city = City::get($city_id);

                if (!$city->getCityId()) {
                    throw new HttpError404Exception(sprintf("Город с указанным идентификатором [%u] не найден", $city_id));
                }

                $this->getLayout()
                    ->setSectionTitle($city->getName())
                ;

                BreadCrumbs::getInstance()
                    ->add( new BreadCrumbsItem($city->getName()) )
                ;
            }


            $filter_html_widget = new SightFilterHtmlView();
            $filter_html_widget
                ->setInputData( $this->getUserInputData() )
            ;

            $sight_filter = new SightFilter();

            if ($this->getUserInputData("region")) {
                $sight_filter->setRegionIds($this->getUserInputData("region"));
            }

            if ($this->getUserInputData("city")) {
                $sight_filter->setCityIds($this->getUserInputData("city"));
            }

            if (isset($city)) {
                $filter_html_widget
                    ->setRegions( (new GetCountryRegions($city->getCountryId()))->getRegions() )
                    ->setCities( (new GetAllCities())->getCities() )
                    ->addSelectedCity($city_id)
                ;

                $sight_filter
                    ->addCityId($city_id)
                ;
            } else {
                $filter_html_widget
                    ->setCities( (new GetAllCities())->getCities() )
                    ->setRegions( (new GetCountryRegions(CountriesEnumHelper::Russia->value))->getRegions() )
                ;
            }

            $sights = new GetVisibleSights();
            $sights
                ->setFilter($sight_filter)
            ;


            $this->getView()
                ->setSights( $sights->getSights() )
                ->setFilter( $filter_html_widget )
            ;

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}