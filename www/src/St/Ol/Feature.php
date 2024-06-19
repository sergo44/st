<?php

namespace St\Ol;

class Feature implements \JsonSerializable
{
    /**
     * Идентификатор объекта
     * @var string
     */
    protected string $id;
    /**
     * Тип объекта
     * @var string
     */
    protected string $type = "Feature";
    /**
     * Геометрия объекта
     * @var string
     */
    protected string $geometry_name = "SHAPE";
    /**
     * Геометрия объекта
     * @var FeatureGeometry
     */
    protected FeatureGeometry $geometry;

    /**
     * Устанавливает id
     * @param string $id
     * @return Feature
     * @see id
     */
    public function setId(string $id): Feature
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Устанавливает geometry
     * @param FeatureGeometry $geometry
     * @return Feature
     * @see geometry
     */
    public function setGeometry(FeatureGeometry $geometry): Feature
    {
        $this->geometry = $geometry;
        return $this;
    }

    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "type" => $this->type,
            "geometry_name" => $this->geometry_name,
            "geometry" => $this->geometry,
            "properties" => array(
                "source_id" => $this->id
            )
        );
    }


}