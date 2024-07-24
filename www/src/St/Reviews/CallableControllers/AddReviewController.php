<?php

namespace St\Reviews\CallableControllers;

use St\ApplicationError;
use St\DateTimeHelper;
use St\Db;
use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Images\ImageCropper;
use St\Images\ImageException;
use St\Result;
use St\Review;
use St\ReviewImage;
use St\Reviews\ReviewStore;
use St\ReviewStatusesEnum;
use St\UploadedFile;

class AddReviewController extends UserCallableController implements ICallableController
{
    /**
     * Метод контроллера добавления отзыва
     * @throws ApplicationError
     */
    public function index(int $object_id): AddReviewController
    {
        $this->getView()
            ->setResult($result = new Result())
        ;

        try {

            $review = new Review();
            $review
                ->setUserId($this->getUser()->getUserId())
                ->setObjectId($object_id)
                ->setPublishDatetimeUtc(DateTimeHelper::now()->format("Y-m-d H:i:s"))
                ->setRestPeriod($this->getUserInputData("rest_period", 255) ?: "")
                ->setMark((int)$this->getUserInputData("mark"))
                ->setReviewText($this->getUserInputData("review_text", 65535) ?: "")
                ->setStatus(ReviewStatusesEnum::Wait->name)
            ;

            $images = $_FILES['images'] ?: null;

            foreach ($images['name'] as $key => $name) {

                $uploaded_file = new UploadedFile(
                $images['name'][$key] ?? "",
                $images['full_path'][$key] ?? "",
                $images['type'][$key] ?? "",
                $images['tmp_name'][$key] ?? "",
                $images['error'][$key] ?? UPLOAD_ERR_NO_FILE,
                $images['size'][$key] ?? 0
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

                $review_image = new ReviewImage();
                $review_image
                    ->setDirectory($cropper->getSavedFileDir())
                    ->setFilename($cropper->getSavedFileName())
                ;

                $review->addNewImage($review_image);
            }

            $add_review = new ReviewStore($review);
            $add_review->check($result);

            if ($result->isSuccess()) {
                $add_review->add();
            }

        } catch (CallableControllerException | ImageException $e) {
            $this->getView()->getResult()->addError($e->getMessage());
        }
        return $this;
    }
}