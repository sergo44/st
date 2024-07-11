<?php
/**
 * Контроллер редактирования объекта
 */
namespace St\Catalog\CallableControllers;

use St\ApplicationError;
use St\Catalog\AddHotelRoom;
use St\Catalog\EditObject;
use St\Catalog\Views\EditObject\EditObjectHtmlView;
use St\CatalogObject;
use St\CatalogObjectsStatusesEnum;
use St\Countries\GetVisibleCountries;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HotelRoom;
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
        $result = new Result();
        $object = CatalogObject::get($object_id);

        try {

            if (!$object->getObjectId()) {
                throw new HttpError404Exception(sprintf("Объект с идентификатором %s не найден", $object_id));
            }

            if ($this->getUser()?->getUserId() !== $object->getUserId()) {
                throw new HttpError403Exception(sprintf("Попытка редактировать объект %u, который принадлежит пользователю %u от имени пользователя %u", $object->getObjectId(), $object->getUserId(), $this->getUser()?->getUserId()));
            }

            $this->getView()->setCatalogObject($object);

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }

        $this->getView()
            ->setEdit(true)
            ->setResult($result)
            ->setCountriesList((new GetVisibleCountries())->getCountries())
            ;
        ;

        $this->getLayout()
            ->addJs("/build/add_object.bundle.js")
            ->setSectionTitle(sprintf("Редактирование объекта \"%s\"", Strings::escape($object?->getName())));

        return $this;
    }

    /**
     * Контроллер редактирования объекта, метод сохранения изменений
     * @param int $object_id
     * @return $this
     * @throws ApplicationError
     * @throws HttpError403Exception
     * @throws HttpError404Exception
     */
    public function editGo(int $object_id): EditObjectController
    {


        $this->getView()
            ->setEdit(true)
            ->setResult( $result = new Result() )
        ;

        $object = CatalogObject::get($object_id);

        try {
            if (!$object->getObjectId()) {
                throw new HttpError404Exception(sprintf("Объект с идентификатором %s не найден", $object_id));
            }

            if ($this->getUser()?->getUserId() !== $object->getUserId()) {
                throw new HttpError403Exception(sprintf("Попытка редактировать объект %u, который принадлежит пользователю %u от имени пользователя %u", $object->getObjectId(), $object->getUserId(), $this->getUser()?->getUserId()));
            }

            $object
                ->setObjectType($this->getUserInputData("object_type") ?? "")
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
                ->setStatus(CatalogObjectsStatusesEnum::Wait->name)
            ;

            $store = new EditObject($object);
            $store->update();

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

            $hotel_room_uploaded_file = $this->getUserInputData("hotel_room_uploaded_file") ?? array();
            $hotel_room_name = $this->getUserInputData("hotel_room_name") ?? "";
            $hotel_room_description = $this->getUserInputData("hotel_room_description") ?? "";
            $hotel_room_price = $this->getUserInputData("hotel_room_price") ?? "";

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

            $this->getView()->setStored($result->isSuccess());


        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        $this->getLayout()
            ->addJs("/build/add_object.bundle.js")
            ->setSectionTitle(sprintf("Редактирование объекта \"%s\"", Strings::escape($object->getName())));

        return $this;
    }
}