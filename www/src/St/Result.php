<?php

namespace St;

class Result implements \JsonSerializable
{
    /**
     * Признак, что результат выполнился успешно
     * @var bool
     */
    protected bool $success = true;
    /**
     * Признак, что результат выполнился с ошибками
     * @var bool
     */
    protected bool $error = false;
    /**
     * Ошибки, которые есть в объекте
     * @var Error[]
     */
    protected array $errors = array();

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "success" => $this->success,
            "error" => $this->error,
            "errors" => $this->getErrors()
        );
    }

    /**
     * Возвращает признак, что результат успешен
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * Возвращает признак, есть ли ошибки
     * @return bool
     */
    public function hasErrors(): bool
    {
        return sizeof($this->errors) > 0;
    }

    /**
     * Добавление ошибки в результат
     * @param string $message
     * @param string|null $field
     * @return $this
     */
    public function addError(string $message, string|null $field = null): Result
    {
        $this->success = false;
        $this->error = true;
        $this->errors[] = new Error($message, $field);
        return $this;
    }

    /**
     * Возвращает errors
     * @return array
     * @see errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }


}