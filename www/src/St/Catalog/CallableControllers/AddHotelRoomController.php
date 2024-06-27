<?php

namespace St\Catalog\CallableControllers;

use St\Catalog\Views\HotelRooms\AddHotelRoomGoJsonView;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\HotelRoom;
use St\Images\ImageCropper;
use St\Images\ImageException;
use St\Images\ImagesObjectsEnum;
use St\Result;
use St\UploadedFile;
use St\Views\IView;

class AddHotelRoomController extends UserCallableController implements ICallableController
{
    /**
     * Возвращает вид, который используются
     * @return AddHotelRoomGoJsonView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер добавления комнаты
     * @return $this
     */
    public function index(): AddHotelRoomController
    {
        $result = new Result();
        $hotel_room = new HotelRoom();

        $this->getView()
            ->setResult($result)
            ->setHotelRoom($hotel_room)
        ;

        try {

            $hotel_room
                ->setName($this->getUserInputData("add_hotel_room_name", 255) ?: "")
                ->setDescription($this->getUserInputData("add_hotel_room_description", 65535) ?: "")
                ->setPrice((float)$this->getUserInputData("add_hotel_room_price"))
                ;

            $image = $_FILES['add_hotel_room_image'] ?: null;

            if (isset($image)) {
                $uploaded_file = new UploadedFile(
                    $image['name'] ?? "",
                    $image['full_path'] ?? "",
                    $image['type'] ?? "",
                    $image['tmp_name'] ?? "",
                    $image['error'] ?? -1,
                    $image['size'] ?? 0
                );

                if (!$uploaded_file->isUploadedSuccess()) {
                    throw new CallableControllerException(sprintf("Файл не загружен: %s", $uploaded_file->getErrorAsString()));
                }

                $cropper = new ImageCropper();
                $cropper
                    ->setSrcFilePath($uploaded_file->getTmpName())
                    ->setDstFilePath(ST_IMAGES_THUMB_TMP_DIR . "/" . uniqid())
                    ->setResizeGeometry(2000, 2000)
                    ->setCrop(false)
                    ->setAutofixFileExt(true)
                    ->setUnknownExtOutputFormat("jpg")
                    ->open()
                    ->resize()
                    ->save()
                ;

                $hotel_room
                    ->setImage("/" . $cropper->getSavedFileDir() . "/122x86/" . $cropper->getSavedFileName())
                    ->setUploadedFile($cropper->getSavedFileDir() . $cropper->getSavedFileName())
                    ;
            }


        } catch (CallableControllerException | ImageException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}