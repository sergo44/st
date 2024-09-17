<?php

namespace St\Images\CallableControllers;

use St\FrontController\CallableControllerException;
use St\FrontController\ICallableController;
use St\FrontController\UserCallableController;
use St\Result;

class RemoveJustUploadedController extends UserCallableController implements ICallableController
{
    public function index(): self
    {
        $this->getView()
            ->setResult( $result = new Result() )
        ;

        try {

            $path = $this->getUserInputData("path");

            if ($path) {

                $base_path = $full_path = realpath(ST_PUBLIC_WEB_PATH);

                if (!str_ends_with($full_path, "/")) {
                    $base_path = $full_path .= "/";
                }

                $full_path .= ltrim($path, "/");

                $full_path = parse_url($full_path, PHP_URL_PATH);

                $realpath = realpath($full_path);

                if (!$realpath) {
                    throw new CallableControllerException("Изображение не найдено");
                }

                if (!str_starts_with($realpath, $base_path . "upload/")) {
                    throw new CallableControllerException("Ошибка проверки безопасности");
                }

                $dirname = dirname($realpath);
                $filename = basename($realpath);

                if (file_exists($realpath)) {
                    unlink($realpath);
                }

                $original_file = $dirname . "/../" . $filename;
                if (file_exists($original_file)) {
                    unlink($original_file);
                }

            }

        } catch (CallableControllerException $e) {
            $result->addError($e->getMessage());
        }


        return $this;
    }
}