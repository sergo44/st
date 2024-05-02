<?php

namespace St;

class Error implements \JsonSerializable
{
    /**
     * Сообщение об ошибке
     * @var string
     */
    protected string $message = "";
    /**
     * В каком поле произошла ошибка
     * @var string|null
     */
    protected string|null $field = null;

    /**
     * Конструктор объекта
     * @param string $message
     * @param string|null $field
     */
    public function __construct(string $message, string|null $field)
    {
        $this->message = $message;
        $this->field = $field;
    }

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "message" => $this->message,
            "field" => $this->field
        );
    }

    /**
     * Возвращает message
     * @return string
     * @see message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Устанавливает message
     * @param string $message
     * @return Error
     * @see message
     */
    public function setMessage(string $message): Error
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Возвращает field
     * @return string|null
     * @see field
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Устанавливает field
     * @param string|null $field
     * @return Error
     * @see field
     */
    public function setField(?string $field): Error
    {
        $this->field = $field;
        return $this;
    }

}