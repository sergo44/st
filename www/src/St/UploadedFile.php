<?php
/**
 * Объект - загруженный файл
 */
namespace St;

class UploadedFile implements \JsonSerializable
{
    /**
     * Название файла, которое было передано при загрузке
     * @var string
     */
    protected string $name;
    /**
     * Полный путь, где сохранен файл
     * @var string
     */
    protected string $full_path;
    /**
     * Тип файла
     * @var string
     */
    protected string $type;
    /**
     * Временный файл
     * @var string
     */
    protected string $tmp_name;
    /**
     * Признак наличия ошибки загрузки
     * @var int
     */
    protected int $error;
    /**
     * Размер файла в байтах
     * @var int
     */
    protected int $size;

    /**
     * Конструктор объекта
     * @param string $name
     * @param string $full_path
     * @param string $type
     * @param string $tmp_name
     * @param int $error
     * @param int $size
     */
    public function __construct(string $name, string $full_path, string $type, string $tmp_name, int $error, int $size)
    {
        $this->name = $name;
        $this->full_path = $full_path;
        $this->type = $type;
        $this->tmp_name = $tmp_name;
        $this->error = $error;
        $this->size = $size;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "name" => $this->name,
            "full_path" => $this->getFullPath(),
            "type" => $this->getType(),
            "tmp_name" => $this->getTmpName(),
            "error" => $this->getError(),
            "size" => $this->getSize(),
            "error_string" => $this->getErrorAsString()
        );
    }

    /**
     * Возвращает name
     * @return string
     * @see name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Устанавливает name
     * @param string $name
     * @return UploadedFile
     * @see name
     */
    public function setName(string $name): UploadedFile
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Возвращает full_path
     * @return string
     * @see full_path
     */
    public function getFullPath(): string
    {
        return $this->full_path;
    }

    /**
     * Устанавливает full_path
     * @param string $full_path
     * @return UploadedFile
     * @see full_path
     */
    public function setFullPath(string $full_path): UploadedFile
    {
        $this->full_path = $full_path;
        return $this;
    }

    /**
     * Возвращает type
     * @return string
     * @see type
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Устанавливает type
     * @param string $type
     * @return UploadedFile
     * @see type
     */
    public function setType(string $type): UploadedFile
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Возвращает tmp_name
     * @return string
     * @see tmp_name
     */
    public function getTmpName(): string
    {
        return $this->tmp_name;
    }

    /**
     * Устанавливает tmp_name
     * @param string $tmp_name
     * @return UploadedFile
     * @see tmp_name
     */
    public function setTmpName(string $tmp_name): UploadedFile
    {
        $this->tmp_name = $tmp_name;
        return $this;
    }

    /**
     * Возвращает error
     * @return int
     * @see error
     */
    public function getError(): int
    {
        return $this->error;
    }

    /**
     * Устанавливает error
     * @param int $error
     * @return UploadedFile
     * @see error
     */
    public function setError(int $error): UploadedFile
    {
        $this->error = $error;
        return $this;
    }

    /**
     * Возвращает size
     * @return int
     * @see size
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Устанавливает size
     * @param int $size
     * @return UploadedFile
     * @see size
     */
    public function setSize(int $size): UploadedFile
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Возвращает признак, загружен ли файл корректно
     * @return bool
     */
    public function isUploadedSuccess(): bool
    {
        return $this->getError() === UPLOAD_ERR_OK;
    }

    /**
     * Возвращает ошибку в виде строки
     * @return string
     */
    public function getErrorAsString(): string
    {
        return match($this->getError()) {
            UPLOAD_ERR_OK => "Файл загружен успешно",
            UPLOAD_ERR_INI_SIZE => "Размер файла превышает максимально установленный",
            UPLOAD_ERR_FORM_SIZE => "Размер файла превышает максимально установленный веб страницей",
            UPLOAD_ERR_PARTIAL => "Файл был загружен лишь частично",
            UPLOAD_ERR_NO_FILE => "Не указан файл для загрузки",
            UPLOAD_ERR_NO_TMP_DIR => "Ошибка обработки изображения на сервере. К сожалению, не создана временная директория для загрузки файлов",
            UPLOAD_ERR_CANT_WRITE => "Файл был загружен, но нам не удалось записать его на диск. Пожалуйста, попробуйте еще раз или позже",
            UPLOAD_ERR_EXTENSION => "Загрузка файлов была прервана внутренним механизмом"
        };
    }


}