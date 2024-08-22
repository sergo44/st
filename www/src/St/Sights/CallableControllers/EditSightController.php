<?php

namespace St\Sights\CallableControllers;

use St\ApplicationError;
use St\Catalog\AddHotelRoom;
use St\Catalog\EditObject;
use St\CatalogObject;
use St\CatalogObjectsStatusesEnum;
use St\Cities\GetRegionCities;
use St\Countries\GetVisibleCountries;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HotelRoom;
use St\HttpError403Exception;
use St\HttpError404Exception;
use St\Regions\GetCountryRegions;
use St\Result;
use St\Sights\Sight;
use St\Sights\SightImage;
use St\Sights\SightStore;
use St\Sights\Views\EditSight\EditSightHtmlView;
use St\Strings;
use St\Views\IView;

class EditSightController extends UserCallableController implements ICallableController
{
    /**
     * @return EditSightHtmlView
     */
    public function getView(): IView
    {
        return parent::getView();
    }


    /**
     * @return $this
     * @throws ApplicationError
     * @throws HttpError404Exception
     */
    public function index(int $sight_id): self
    {

        $this->getView()
            ->setResult( $result = new Result() )
            ->setCountriesList( (new GetVisibleCountries())->getCountries() )
        ;

        $this->getLayout()
            ->setSectionTitle("Достопримечательности")
            ->addJs("/build/add_sight.bundle.js")
        ;


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

            $this->getView()
                ->setSight($sight)
                ->setRegionsList( (new GetCountryRegions($sight->getCountryId()))->getRegions() )
                ->setCitiesList( (new GetRegionCities($sight->getRegionId()))->getCities() )
            ;

        } catch (CallableControllerException $e) {

            $result->addError($e->getMessage());
        }

        return $this;
    }

    /**
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     * @throws ApplicationError
     */
    public function go(int $sight_id): self
    {

        $this->getView()
            ->setEdit(true)
            ->setResult( $result = new Result() )
            ->setCountriesList( (new GetVisibleCountries())->getCountries() )
        ;

        $this->getLayout()
            ->setSectionTitle("Достопримечательности")
            ->addJs("/build/add_sight.bundle.js")
        ;


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

            $this->getView()
                ->setRegionsList( (new GetCountryRegions($sight->getCountryId()))->getRegions() )
                ;

            $sight
                ->setCountryId((int)($this->getUserInputData("country_id") ?? 0))
                ->setRegionId((int)($this->getUserInputData("region_id") ?? 0))
                ->setCityId((int)($this->getUserInputData("city_id") ?? 0))
                ->setLat((float)($this->getUserInputData("lat") ?? 0))
                ->setLon((float)($this->getUserInputData("lon") ?? 0))
                ->setName((string)($this->getUserInputData("name", 255) ?? 0))
                ->setDescription((string)($this->getUserInputData("description", 65535) ?? 0))
                ->setOperatingMode((string)($this->getUserInputData("operation_mode", 65535) ?? 0))
                ->setPrice((string)($this->getUserInputData("price", 255) ?? 0))
                ->setContactPhone((string)($this->getUserInputData("contact_phone", 255) ?? 0))
                ->setContactEmail((string)($this->getUserInputData("contact_email", 255) ?? 0))
                ->setWebSiteUrl((string)($this->getUserInputData("web_site_url", 255) ?? 0))
                ;

            $store = new SightStore($sight);

            $uploaded_image = $this->getUserInputData("uploaded_image");

            if (isset($uploaded_image['filename']) && is_array($uploaded_image['filename'])) {

                foreach ($uploaded_image['filename'] as $index => $filename) {

                    $image = new SightImage();
                    $image
                        ->setSightId($sight->getSightId())
                        ->setMain(0)
                        ->setDirectory($uploaded_image['directory'][$index])
                        ->setFilename($uploaded_image['filename'][$index])
                        ->setX1($uploaded_image['x1'][$index])
                        ->setY1($uploaded_image['y1'][$index])
                        ->setX2($uploaded_image['x2'][$index])
                        ->setY2($uploaded_image['y2'][$index])
                        ->setRatio($uploaded_image['ratio'][$index])
                    ;

                    $store->addImage($image);
                }
            }

            $this->getView()
                ->setSight($sight)
                ->setEdit(true)
                ->setShowSuccessWindow(true)
            ;

        } catch (CallableControllerException $e) {

            $result->addError($e->getMessage());
        }

        return $this;

    }
}