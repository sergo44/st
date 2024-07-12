<?php

namespace St\Catalog\CallableControllers;

use St\Catalog\RemoveHotelRoom;
use St\CatalogObject;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HttpError404Exception;
use St\Result;

class RemoveRoomController extends UserCallableController implements ICallableController
{
    /**
     * Контроллер удаления номера
     * @return $this
     * @throws HttpError404Exception
     */
    public function index(int $object_id, int $room_id): RemoveRoomController
    {

        $this->getView()->setResult( $result = new Result());

        try {

            $room = null;

            $object = CatalogObject::get($object_id);
            if (!$object->getObjectId()) {
                throw new HttpError404Exception(sprintf("Объект каталога с указанным id (%u) не найден", $object_id));
            }

            foreach ($object->getHotelRooms() as $hotel_room) {
                if ($room_id === $hotel_room->getHotelRoomId()) {
                    $room =  $hotel_room;
                }
            }

            if (!$room) {
                throw new CallableControllerException("Указанный вами номер не найден");
            }

            $remover = new RemoveHotelRoom($room);
            $remover->remove($result);

        } catch (CallableControllerException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }

        return $this;
    }
}