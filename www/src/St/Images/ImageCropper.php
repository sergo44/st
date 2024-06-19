<?php

namespace St\Images;

use Imagick;
use ImagickException;
use St\Fs;

class ImageCropper
{
    /**
     * Аттрибут содержит путь до источника изображения
     * @var string
     */
    protected string $src_file_path;

    /**
     * Аттрибут содержит путь до получателя
     * @var string
     */
    protected string $dst_file_path;
    /**
     * Путь до сохраненного файла
     * @var string
     */
    protected string $saved_file_path;
    /**
     * Путь сохраненного файла
     * @var string
     */
    protected string $saved_file_dir;
    /**
     * Имя сохраненного файла
     * @var string
     */
    protected string $saved_file_name;

    /**
     * Ширина / максимальная ширина до которой необходимо изменить изображение
     * @var int
     */
    protected int $resize_width;

    /**
     * Высота / максимальная высота до которой необходимо изменить изображение
     * @var int
     */
    protected int $resize_height;

    /**
     * Если есть область, то аттрибут содержит координату x1
     * @var int
     */
    protected int $x1;

    /**
     * Если есть область, то аттрибут содержит координату y1
     * @var int
     */
    protected int $y1;

    /**
     * Если есть область, то аттрибут содержит координату x2
     * @var int
     */
    protected int $x2;

    /**
     * Если есть область, то аттрибут содержит координату y2
     * @var int
     */
    protected int $y2;

    /**
     * Если есть область, и задана с помощью коэффициентов K, то аттрибут содержит коэффициент x1
     * @var float
     */
    protected float $kx1;

    /**
     * Если есть область, и задана с помощью коэффициентов K, то аттрибут содержит коэффициент x1
     * @var float
     */
    protected float $ky1;

    /**
     * Если есть область, и задана с помощью коэффициентов K, то аттрибут содержит коэффициент x2
     * @var float
     */
    protected float $kx2;

    /**
     * Если есть область, и задана с помощью коэффициентов K, то аттрибут содержит коэффициент y2
     * @var float
     */
    protected float $ky2;

    /**
     * Если необходимо отрезать фото, то отрежем. Либо по выделенной области, либо по значениям resize_width / resize_height
     * @var bool
     */
    protected bool $crop;

    /**
     * Флаг разрешает коррекцию расширения в зависимости от mime типа изображения. Если установлен в false, то будет использовано, то же расширение, что и у DST файла
     * @var boolean
     */
    protected bool $autofix_file_ext = true;

    /**
     * Если пользователь пытается загрузить специфически форматы (PSD и т.п.), то они будут переведены в этот тип изображения (если задано),
     * и будет заменено расширение изображения (в любом случае)
     * @var string
     */
    protected string $unknown_ext_output_format = "png";

    /**
     * Какие разрешено использовать форматы. Если установлен флаг unknown_ext_output_format, то формат будет заменен, если его нет в указанном массиве
     * @var array
     */
    protected array $allowed_formats = array("jpeg", "jpg", "bmp", "wbmp", "bmp1", "bmp2", "bmp3", "png", "gif");

    /**
     * Содержит инстанцию текущего объекта imagick
     * @var Imagick
     */
    protected Imagick $imagick_instance;

    /**
     * Before save callback
     * @var callable
     */
    protected $before_save_callback;

    /**
     * Сеттер для источника
     * @param string $path
     * @return $this
     */
    public function setSrcFilePath(string $path): ImageCropper
    {
        $this->src_file_path = $path;
        return $this;
    }

    /**
     * Геттер для источника
     * @return string
     */
    public function getSrcFilePath(): string
    {
        return $this->src_file_path;
    }

    /**
     * Сеттер для назначения
     * @param string $path
     * @return $this
     */
    public function setDstFilePath(string $path): ImageCropper
    {
        $this->dst_file_path = $path;
        return $this;
    }

    /**
     * Геттер для назначения
     * @return string
     */
    public function getDstFilePath(): string
    {
        return $this->dst_file_path;
    }

    /**
     * Возвращает saved_file_path
     * @return string
     * @see saved_file_path
     */
    public function getSavedFilePath(): string
    {
        return $this->saved_file_path;
    }

    /**
     * Возвращает saved_file_dir
     * @return string
     * @see saved_file_dir
     */
    public function getSavedFileDir(): string
    {
        return $this->saved_file_dir;
    }

    /**
     * Возвращает saved_file_name
     * @return string
     * @see saved_file_name
     */
    public function getSavedFileName(): string
    {
        return $this->saved_file_name;
    }

    /**
     * Устанавливает разрешения для изменения изображения
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function setResizeGeometry(int $width, int $height): ImageCropper
    {
        $this->resize_width = $width;
        $this->resize_height = $height;
        return $this;
    }

    /**
     * Устанавливает область
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @return $this
     */
    public function setSelectedArea(int $x1, int $y1, int $x2, int $y2): ImageCropper
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;

        return $this;
    }

    /**
     * Устанавливает область по коэффициентам
     * @param float $kx1
     * @param float $ky1
     * @param float $kx2
     * @param float $ky2
     * @return $this
     */
    public function setSelectedAreaByCoefficients(float $kx1, float $ky1, float $kx2, float $ky2): ImageCropper
    {
        $this->kx1 = $kx1;
        $this->ky1 = $ky1;
        $this->kx2 = $kx2;
        $this->ky2 = $ky2;

        return $this;
    }

    /**
     * Сеттер для флага обрезки
     * @param bool $crop
     * @return $this
     */
    public function setCrop(bool $crop): ImageCropper
    {
        $this->crop = $crop;
        return $this;
    }

    /**
     * Геттер для флага отрезки
     * @return bool
     */
    public function getCrop(): bool
    {
        return $this->crop;
    }


    /**
     * Если пользователь пытается залить изображение редких форматов (xcf, psd),
     * то флаг задает необходимость привести к заданному типу это изображение
     * @param string $format
     * @return $this
     */
    public function setUnknownExtOutputFormat(string $format): ImageCropper
    {
        $this->unknown_ext_output_format = $format;
        return $this;
    }

    /**
     *
     * @param array $formats
     * @return $this
     */
    public function setAllowedFormats(array $formats): ImageCropper
    {
        $this->allowed_formats = $formats;
        return $this;
    }

    /**
     * Устанавливает флаг "не заменять расширение файла", а использовать то, которое у оригинала
     * @param bool $flag
     * @return $this
     */
    public function setAutofixFileExt(bool $flag): ImageCropper
    {
        $this->autofix_file_ext = $flag;
        return $this;
    }

    /**
     * Set callback function before save image
     * @param callable $callable
     * @return $this
     */
    public function setBeforeSaveCallback(callable $callable): ImageCropper
    {
        $this->before_save_callback = $callable;
        return $this;
    }

    /**
     * Получаем координаты выделенной области относительно миниатюры
     * @param  float $k
     * @return \stdClass
     * @throws ImageException|ImagickException
     */
    public function getAreaResizedCoordinates(float $k = 1): \stdClass
    {
        $return = new \stdClass();
        $return->use = false;

        if (!isset($this->imagick_instance)) {
            throw new ImageException("Instance imagick first!");
        }

        // Если установлено относительно коэффициентов от большей стороны
        if (isset($this->kx1) && $this->kx1 > 0 && $this->kx1 <= 1 &&
            isset($this->ky1) && $this->ky1 > 0 && $this->ky1 <= 1 &&
            isset($this->kx2) && $this->kx2 > 0 && $this->kx2 <= 1 && $this->kx2 > $this->kx1 &&
            isset($this->ky2) && $this->ky2 > 0 && $this->ky2 <= 1 && $this->ky2 > $this->ky1) {

            $return->x1 = intval($this->imagick_instance->getimagewidth() * $this->kx1);
            $return->y1 = intval($this->imagick_instance->getimageheight() * $this->ky1);
            $return->x2 = intval($this->imagick_instance->getimagewidth() * $this->kx2);
            $return->y2 = intval($this->imagick_instance->getimageheight() * $this->ky2);
            $return->use = true;

            return $return;
        }

        // Если установлено относительно коэффициентов от меньшей стороны (для обработки совместимости)
        if (isset($this->kx1) && $this->kx1 >= 1 &&
            isset($this->ky1) && $this->ky1 >= 1 &&
            isset($this->kx2) && $this->kx2 >= 1 && $this->kx2 < $this->kx1 &&
            isset($this->ky2) && $this->ky2 >= 1 && $this->ky2 < $this->ky1) {

            $return->x1 = intval($this->imagick_instance->getimagewidth() / $this->kx1);
            $return->y1 = intval($this->imagick_instance->getimageheight() / $this->ky1);
            $return->x2 = intval($this->imagick_instance->getimagewidth() / $this->kx2);
            $return->y2 = intval($this->imagick_instance->getimageheight() / $this->ky2);
            $return->use = true;

            return $return;
        }

        // Если установлено относительно координат источника
        if (isset($this->x1) && $this->x1 >= 0 &&
            isset($this->y1) && $this->y1 >= 0 &&
            isset($this->x2) && $this->x2 > $this->x1 &&
            isset($this->y2) && $this->y2 > $this->y1) {

            $return->x1 = intval($this->x1);
            $return->y1 = intval($this->y1);
            $return->x2 = intval($this->x2);
            $return->y2 = intval($this->y2);
            $return->use = true;

            return $return;
        }

        return $return;
    }

    /**
     * Открывает источник
     * @return $this
     * @throws ImageException
     */
    public function open(): ImageCropper
    {
        if (!$this->getSrcFilePath()) {
            throw new ImageException("Attribute src_file_path is unset!");
        }

        if (!file_exists($this->getSrcFilePath()) || !is_file($this->getSrcFilePath()) || !is_readable($this->getSrcFilePath())) {
            throw new ImageException("Файл {$this->getSrcFilePath()} не доступен для чтения или не является файлом");
        }

        if (isset($this->imagick_instance)) {
            throw new ImageException("Объект imagick уже существует. Повторный вызов " . __METHOD__ . " в " . __CLASS__ . " ");
        }

        try {
            $this->imagick_instance = new Imagick($this->getSrcFilePath());
            $this->imagick_instance->setImageBackgroundColor('#FFFFFF');
            $this->imagick_instance->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);

            if ($this->imagick_instance->getimagewidth() <= 0 || $this->imagick_instance->getimageheight() <= 0) {
                throw new ImageException("Неизвестный тип изображения " . __METHOD__ . " в " . __CLASS__ . " (#unknown demision)");
            }
        } catch (ImagickException $e) {
            throw new ImageException("Ошибка открытия изображения. Скорее всего вы пытаетесь загрузить/открыть изображение недопустимого формата");
        }

        return $this;
    }

    /**
     * Возвращает текущую ширину
     * @return int
     * @throws ImageException|ImagickException
     */
    public function getResizedWidth(): int
    {
        if (!isset($this->imagick_instance)) {

            throw new ImageException("Instance imagick first!");
        }

        return $this->imagick_instance->getimagewidth();
    }

    /**
     * Get the current image
     * @return int
     * @throws ImageException|ImagickException
     */
    public function getResizedHeight(): int
    {
        if (!isset($this->imagick_instance)) {

            throw new ImageException("Instance imagick first!");
        }

        return $this->imagick_instance->getimageheight();
    }

    /**
     * Изменяем размер изображения
     * @throws ImageException
     */
    public function resize(): ImageCropper
    {
        if (!isset($this->imagick_instance)) {

            throw new ImageException("Instance imagick first!");
        }

        if ($this->crop) {

            $this->crop();

        } else {

            $this->thumbnail();
        }

        return $this;
    }

    /**
     * Метод создания миниатюры (обрезки)
     * @return $this
     * @throws ImageException
     */
    protected function thumbnail(): ImageCropper
    {
        // Изменим размер изображения
        try {

            $k_width = $k_height = 1;

            $source_width = $this->imagick_instance->getimagewidth();
            $source_height = $this->imagick_instance->getimageheight();

            if ($this->resize_width > 0) {
                $k_width = min(1, $this->resize_width / $source_width);
            }

            if ($this->resize_height > 0) {
                $k_height = min(1, $this->resize_height / $source_height);
            }

            if ($this->crop) {
                $k = max($k_width, $k_height);
            } else {
                $k = min($k_width, $k_height);
            }

            if ($k <= 1.0) {
                $this->imagick_instance = $this->imagick_instance->coalesceImages();

                foreach ($this->imagick_instance as $frame) {
                    $frame->setImageBackgroundColor('#FFFFFF');
                    $frame->mergeImageLayers(Imagick::LAYERMETHOD_FLATTEN);
                    $frame->resizeimage(intval($source_width * $k), intval($source_height * $k), Imagick::FILTER_LANCZOS, 1);
                }

                $this->imagick_instance = $this->imagick_instance->deconstructImages();
            }
        } catch (ImagickException $e) {
            throw new ImageException("Неизвестная ошибка ресайза изображения");
        }

        return $this;
    }

    /**
     * Метод отрезки
     * @throws ImageException
     */
    protected function crop(): ImageCropper
    {
        // Crop
        try {

            $k_width = $k_height = 1;

            $source_width = $this->imagick_instance->getimagewidth();
            $source_height = $this->imagick_instance->getimageheight();

            if ($this->resize_width > 0) {
                $k_width = min(1, $this->resize_width / $source_width);
            }

            if ($this->resize_height > 0) {
                $k_height = min(1, $this->resize_height / $source_height);
            }

            $k = max($k_width, $k_height);
            $c = min($k_width, $k_height);

            if ($this->crop && $this->resize_width > 0 && $this->resize_height > 0 && $c <= 1.0) {
                $area = $this->getAreaResizedCoordinates($k);

                if ($area->use) {
                    // Crop by area
                    $this->imagick_instance = $this->imagick_instance->coalesceImages();
                    foreach ($this->imagick_instance as $frame) {
                        $frame->cropimage(
                            $area->x2 - $area->x1,
                            $area->y2 - $area->y1,
                            $area->x1,
                            $area->y1
                        );

                        $frame->thumbnailImage($area->x2 - $area->x1, $area->y2 - $area->y1);
                    }

                    $this->imagick_instance = $this->imagick_instance->deconstructImages();
                    // Уменьшим вырезанную область до нужного размера после обрезки
                    $this->thumbnail();

                } else {
                    // Crop center
                    // Уменьшим вырезанную область до нужного размера до обрезки
                    $this->thumbnail();

                    $this->imagick_instance = $this->imagick_instance->coalesceImages();

                    foreach ($this->imagick_instance as $frame) {

                        $this->imagick_instance->cropimage(
                            $this->resize_width,
                            $this->resize_height,
                            $this->imagick_instance->getimagewidth() > $this->resize_width ? ($this->imagick_instance->getimagewidth() - $this->resize_width) / 2 : 0,
                            $this->imagick_instance->getimageheight() > $this->resize_height ? ($this->imagick_instance->getimageheight() - $this->resize_height) / 2 : 0
                        );

                        $frame->thumbnailImage($this->resize_width, $this->resize_height);
                    }

                    $this->imagick_instance = $this->imagick_instance->deconstructImages();
                }
            }

        } catch (ImagickException $e) {
            throw new ImageException("Неизвестная ошибка ресайза изображения");
        }

        return $this;
    }

    /**
     * Save image to DST File Path
     * @return $this
     * @throws ImageException
     */
    public function save(): ImageCropper
    {
        if (!isset($this->imagick_instance)) {
            throw new ImageException("Instance imagick first!");
        }

        if (!$this->dst_file_path) {
            throw new ImageException("Set dst filepath before save!");
        }

        try {
            if ($this->autofix_file_ext) {
                $ext = strtolower($this->imagick_instance->getimageformat());
            } else {
                $ext = strtolower(pathinfo($this->src_file_path, PATHINFO_EXTENSION));
            }

            if (!$ext) {
                throw new ImageException("Не возможно определить тип загружаемого изображения (#imagick)");
            }

            if (!in_array($ext, $this->allowed_formats)) {

                if ($this->unknown_ext_output_format) {

                    if (!in_array($this->unknown_ext_output_format, $this->allowed_formats)) {
                        throw new ImageException("Попытка использовать {$this->unknown_ext_output_format} для выходного изображения, которое не поддерживается (unknown image ext convert to)");
                    }

                    $ext = $this->unknown_ext_output_format;

                } else {
                    throw new ImageException("Не известное расширение выходного файла");
                }

            }

            if (file_exists($this->dst_file_path) && is_dir($this->dst_file_path)) {
                $dir = $this->getDstFilePath();
                $filename = pathinfo($this->src_file_path, PATHINFO_FILENAME);
            } else {
                $dir = pathinfo($this->dst_file_path, PATHINFO_DIRNAME);
                $filename = pathinfo($this->dst_file_path, PATHINFO_FILENAME);

                if (!$this->autofix_file_ext && $ext !== pathinfo($this->dst_file_path, PATHINFO_EXTENSION) && !$this->unknown_ext_output_format) {
                    throw new ImageException("Попытка переопределить заданное в dst расширение файла: " . pathinfo($this->dst_file_path, PATHINFO_FILENAME) . " на {$ext}");
                }
            }

            if (!file_exists($dir)) {
                Fs::mkdir_recursive($dir);
            }

            if (!file_exists($dir) || !is_dir($dir) || !is_writable($dir)) {
                throw new ImageException("Нет или не доступна для записи директория {$dir}");
            }

            if (!str_ends_with($dir, "/")) {
                $dir = $dir . "/";
            }

            if ($ext == "jpeg" || $ext == "jpg") {
                $this->imagick_instance->setimageformat("jpeg");
                $this->imagick_instance->setimagecompression(Imagick::COMPRESSION_LOSSLESSJPEG);

            } elseif ($ext == "bmp" || $ext == "wbmp" || $ext == "bmp1" || $ext == "bmp2" || $ext == "bmp3") {
                $this->imagick_instance->setimageformat("bmp");

            } elseif ($ext == "gif") {
                $this->imagick_instance->setimageformat("gif");
                $this->imagick_instance->setimagecompressionquality(100);

            } elseif ($ext == "png") {
                $this->imagick_instance->setimageformat("png");
                $this->imagick_instance->setimagecompression(Imagick::COMPRESSION_LZW);

            } else {
                throw new ImageException("Неподдерживаемый формат выходного изображения");
            }

            if (is_callable($this->before_save_callback)) {
                call_user_func($this->before_save_callback);
            }

            $this->saved_file_dir = $dir;
            $this->saved_file_name = $filename . "." . $ext;
            $this->saved_file_path = $this->saved_file_dir . $this->saved_file_name;

            if (strtolower($this->imagick_instance->getimageformat()) == "gif") {
                $this->imagick_instance->writeimages($this->saved_file_path, true);
            } else {
                $this->imagick_instance->writeimage($this->saved_file_path);
            }

            return $this;
        } catch (ImagickException $e) {
            throw new ImageException("Не могу сохранить изображение: {$e->getMessage()}");
        }
    }
}