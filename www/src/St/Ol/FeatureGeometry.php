<?php

namespace St\Ol;

class FeatureGeometry implements \JsonSerializable
{
    /**
     * Тип - точка
     * @var string
     */
    protected string $type = "Point";
    /** Широта точки
     * @var float
     */
    protected float $lat;
    /**
     * Долгота точки
     * @var float
     */
    protected float $lon;

    /**
     * Создание геометрической фигуры (точки)
     * @param float $lat
     * @param float $lon
     */
    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "type" => $this->type,
            "coordinates" => array($this->lat, $this->lon)
        );
    }


}