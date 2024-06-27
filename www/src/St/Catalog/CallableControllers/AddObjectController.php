<?php

namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\AddHotelRoom;
use St\Catalog\AddObject;
use St\Catalog\Views\AddObject\AddObjectHtmlView;
use St\CatalogObject;
use St\Countries\GetVisibleCountries;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HotelRoom;
use St\Result;
use St\Views\IView;

class AddObjectController extends UserCallableController implements ICallableController
{
    /**
     * Указывает какой шаблон, который возвращается контроллером
     * @return AddObjectHtmlView|IView
     */
    #[\Override] public function getView(): AddObjectHtmlView|IView
    {
        return parent::getView();
    }

    /**
     * Контролер отображения формы добавления объекта
     * @return ICallableController
     * @throws ApplicationError
     */
    public function index(): ICallableController
    {
        $this->getLayout()
            ->setSectionTitle("Добавление объекта")
            ->addJs("/build/add_object.bundle.js")
        ;

        $this->getView()
            ->setCountriesList((new GetVisibleCountries())->getCountries())
            ->setCatalogObject(new CatalogObject())
        ;

        return $this;
    }

    /**
     * Метод добавления объекта
     * @throws ApplicationError
     */
    public function addGo(): ICallableController
    {
        $this->getLayout()
            ->setSectionTitle("Добавление объекта")
            ->addJs("/build/add_object.bundle.js")
        ;

        $result = new Result();
        $object = new CatalogObject();

        $this->getView()
            ->setResult($result)
            ->setCountriesList((new GetVisibleCountries())->getCountries())
            ->setCatalogObject($object)
        ;

        try {

            $object
                ->setObjectType($this->getUserInputData("object_type") ?? "")
                ->setUserId($this->getUser()->getUserId())
                ->setName($this->getUserInputData("name") ?? "")
                ->setCountryId($this->getUserInputData("country_id") ?? 0)
                ->setRegionId($this->getUserInputData("region_id") ?? 0)
                ->setCityId($this->getUserInputData("city_id") ?? 0)
                ->setAddressLines($this->getUserInputData("address_lines") ?? "")
                ->setLat($this->getUserInputData("lat") ?? 0.0)
                ->setLon($this->getUserInputData("lon") ?? 0.0)
                ->setDescription($this->getUserInputData("description") ?? "")
                ->setIncludeFoods($this->getUserInputData("include_foods") ?? "")
                ->setStartPrice($this->getUserInputData("start_price") ?? 0)
                ->setContactPhone($this->getUserInputData("contact_phone") ?? "")
                ->setContactEmail($this->getUserInputData("contact_email") ?? "")
                ->setWebSiteUrl($this->getUserInputData("web_site_url") ?? "")
                ;

            $store = new AddObject($object);
            $store->add();

            $this->getView()->setAdded($result->isSuccess());

            $uploaded_image = $this->getUserInputData("uploaded_image");

            if (isset($uploaded_image['filename']) && is_array($uploaded_image['filename'])) {
                foreach ($uploaded_image['filename'] as $index => $filename) {
                    $store->addImage(
                        $uploaded_image['directory'][$index],
                        $uploaded_image['filename'][$index],
                        $uploaded_image['x1'][$index],
                        $uploaded_image['y1'][$index],
                        $uploaded_image['x2'][$index],
                        $uploaded_image['y2'][$index],
                        $uploaded_image['ratio'][$index]
                    );
                }
            }

            // $hotel_room_id = $this->getUserInputData("hotel_room_id");
            $hotel_room_uploaded_file = $this->getUserInputData("hotel_room_uploaded_file");
            $hotel_room_name = $this->getUserInputData("hotel_room_name");
            $hotel_room_description = $this->getUserInputData("hotel_room_description");
            $hotel_room_price = $this->getUserInputData("hotel_room_price");

            foreach ($hotel_room_uploaded_file as $key => $uploaded_file) {
                $hotel_room = new HotelRoom();
                $hotel_room
                    ->setHotelRoomId(null)
                    ->setObjectId($object->getObjectId())
                    ->setImage($uploaded_file)
                    ->setName($hotel_room_name[$key])
                    ->setDescription($hotel_room_description[$key])
                    ->setPrice($hotel_room_price[$key])
                    ;

                $rooms_store = new AddHotelRoom( $hotel_room );
                $rooms_store->add();

            }

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}