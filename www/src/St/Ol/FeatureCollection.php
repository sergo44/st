<?php
/**
 * Объект FeatureCollection (Open Layers)
 */
namespace St\Ol;

class FeatureCollection implements \JsonSerializable
{
    /**
     * Тип объекта
     * @var string
     */
    protected string $type = "FeatureCollection";

    /**
     * Объекты для отображения
     * @var Feature[]
     */
    protected array $features = array();

    protected array $crs = array(
        "type" => "name",
        "properties" => array(
            "name" => "urn:ogc:def:crs:EPSG::4326"
        )
    );

    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "type" => $this->type,
            "totalFeatures" => sizeof($this->features),
            "features" => $this->features,
            "crs" => $this->crs
        );
    }

    /**
     * Добавляет объект
     * @param Feature $feature
     * @return $this
     */
    public function addFeature(Feature $feature): FeatureCollection
    {
        $this->features[] = $feature;
        return $this;
    }
}