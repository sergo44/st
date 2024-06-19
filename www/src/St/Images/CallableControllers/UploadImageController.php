<?php

namespace St\Images\CallableControllers;

use St\FrontController\CallableController;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\HttpError404Exception;
use St\Images\ImageCropper;
use St\Images\ImageException;
use St\Images\ImagesObjectsEnum;
use St\Images\Views\UploadImageResultJsonView;
use St\Result;
use St\UploadedFile;
use St\Views\IView;

class UploadImageController extends CallableController implements ICallableController
{
    /**
     * Возвращает вид (для точного указания типа возвращаемого объекта)
     * @return UploadImageResultJsonView
     */
    #[\Override] public function getView(): IView
    {
        return parent::getView();
    }

    /**
     * Контроллер загрузки изображений
     * @throws HttpError404Exception
     */
    public function index($object_type): UploadImageController
    {

        if (!defined(ImagesObjectsEnum::class . "::" . $object_type)) {
            throw new HttpError404Exception("Unknown (undeclared) object type {$object_type}");
        }

        $image = $this->getUserInputData("image");
        if (!$image) {
            throw new HttpError404Exception("Image not specified");
        }

        $result = new Result();
        $this->getView()->setResult($result);

        try {

            $uploaded_file = new UploadedFile(
                $image['name'][0] ?? "",
                $image['full_path'][0] ?? "",
                $image['type'][0] ?? "",
                $image['tmp_name'][0] ?? "",
                $image['error'][0] ?? -1,
                $image['size'][0] ?? 0
            );

            /** @var ImagesObjectsEnum $enum */
            $enum = ImagesObjectsEnum::{$object_type};

            if (!$uploaded_file->isUploadedSuccess()) {
                throw new CallableControllerException(sprintf("Файл не загружен: %s", $uploaded_file->getErrorAsString()));
            }

            $this->getView()->setUploadedFile($uploaded_file);


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

            $this->getView()
                ->setDirectory($cropper->getSavedFileDir())
                ->setFilename($cropper->getSavedFileName())
                ->setUri($cropper->getSavedFileDir() . $cropper->getSavedFileName())
                ->setRatio($enum->ratio())
                ;

        } catch (CallableControllerException|ImageException $e) {
            $result->addError($e->getMessage());
        }

        return $this;
    }
}