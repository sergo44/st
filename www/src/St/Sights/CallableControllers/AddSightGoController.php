<?php

namespace St\Sights\CallableControllers;

use St\ApplicationError;
use St\Countries\GetVisibleCountries;
use St\DateTimeHelper;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;
use St\Sights\Sight;
use St\Sights\SightImage;
use St\Sights\SightStore;
use St\Sights\Views\AddSight\AddSightGoHtmlView;
use St\Views\IView;

class AddSightGoController extends UserCallableController implements ICallableController
{
    /**
     * Возвращает вид
     * @return AddSightGoHtmlView
     */
    public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер добавления достопримечательности
     * @throws ApplicationError
     */
    public function index(): AddSightGoController
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

            $sight = new Sight();
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

                ->setUserId( $this->getUser()->getUserId())
                ->setCreatedDatetimeUtc( DateTimeHelper::now()->format("Y-m-d H:i:s"))
                ;

            $store = new SightStore($sight);
            $store->add();

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

            $this->getView()->setShowSuccessWindow(true);


        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}