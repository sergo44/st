<?php

namespace St;

class BreadCrumbsItem
{
    /**
     * Заголовок хлебной крошки
     * @var string
     */
    protected string $label;
    /**
     * URI хлебной крошки
     * @var string|null
     */
    protected ?string $uri;

    /**
     * Конструктор класса
     * @param string $label
     * @param string|null $uri
     */
    public function __construct(string $label, ?string $uri = null)
    {
        $this->label = $label;
        $this->uri = $uri;
    }

    /**
     * Возвращает label
     * @return string
     * @see label
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Устанавливает label
     * @param string $label
     * @return BreadCrumbsItem
     * @see label
     */
    public function setLabel(string $label): BreadCrumbsItem
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Возвращает uri
     * @return string|null
     * @see uri
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * Устанавливает uri
     * @param string|null $uri
     * @return BreadCrumbsItem
     * @see uri
     */
    public function setUri(?string $uri): BreadCrumbsItem
    {
        $this->uri = $uri;
        return $this;
    }


}