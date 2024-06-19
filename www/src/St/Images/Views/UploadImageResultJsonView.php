<?php

namespace St\Images\Views;

use St\Result as Result;
use St\UploadedFile;
use St\Views\IView;
use St\Views\JsonView;

class UploadImageResultJsonView extends JsonView implements IView, \JsonSerializable
{
    /**
     * Директория, куда загружено изображение
     * @var string
     */
    protected string $directory = "";
    /**
     * Имя файла, которое было загружено
     * @var string
     */
    protected string $filename = "";
    /**
     * URI изображения
     * @var string
     */
    protected string $uri = "";
    /**
     * Отношение сторон
     * @var string
     */
    protected string $ratio = "1/1";
    /**
     * Объект - загруженное изображение
     * @var UploadedFile|null
     */
    protected ?UploadedFile $uploaded_file = null;

    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult(),
            "file" => array(
                "directory" => $this->directory,
                "filename" => $this->filename,
                "uri" => sprintf("/%s", $this->uri)
            ),
            "uploaded_file" => $this->uploaded_file,
            "ratio" => $this->ratio
        );
    }

    /**
     * Возвращает directory
     * @return string
     * @see directory
     */
    public function getDirectory(): string
    {
        return $this->directory;
    }

    /**
     * Устанавливает directory
     * @param string $directory
     * @return UploadImageResultJsonView
     * @see directory
     */
    public function setDirectory(string $directory): UploadImageResultJsonView
    {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Возвращает filename
     * @return string
     * @see filename
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Устанавливает filename
     * @param string $filename
     * @return UploadImageResultJsonView
     * @see filename
     */
    public function setFilename(string $filename): UploadImageResultJsonView
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Возвращает uri
     * @return string
     * @see uri
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Устанавливает uri
     * @param string $uri
     * @return UploadImageResultJsonView
     * @see uri
     */
    public function setUri(string $uri): UploadImageResultJsonView
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * Возвращает uploaded_file
     * @return UploadedFile|null
     * @see uploaded_file
     */
    public function getUploadedFile(): ?UploadedFile
    {
        return $this->uploaded_file;
    }

    /**
     * Устанавливает uploaded_file
     * @param UploadedFile|null $uploaded_file
     * @return UploadImageResultJsonView
     * @see uploaded_file
     */
    public function setUploadedFile(?UploadedFile $uploaded_file): UploadImageResultJsonView
    {
        $this->uploaded_file = $uploaded_file;
        return $this;
    }

    /**
     * Возвращает ratio
     * @return string
     * @see ratio
     */
    public function getRatio(): string
    {
        return $this->ratio;
    }

    /**
     * Устанавливает ratio
     * @param string $ratio
     * @return UploadImageResultJsonView
     * @see ratio
     */
    public function setRatio(string $ratio): UploadImageResultJsonView
    {
        $this->ratio = $ratio;
        return $this;
    }

}