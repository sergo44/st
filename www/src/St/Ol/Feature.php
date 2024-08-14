<?php

namespace St\Ol;

use Override;

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
     * Содержимое всплывающего окна
     * @var string
     */
    protected string $tooltip_content = "";
    /**
     * УРЛ до подробной информации
     * @var string
     */
    protected string $about_url = "";
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
     * Устанавливает tooltip_content
     * @param string $tooltip_content
     * @return Feature
     * @see tooltip_content
     */
    public function setTooltipContent(string $tooltip_content): Feature
    {
        $this->tooltip_content = $tooltip_content;
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
     * Возвращает about_url
     * @return string
     * @see about_url
     */
    public function getAboutUrl(): string
    {
        return $this->about_url;
    }

    /**
     * Устанавливает about_url
     * @param string $about_url
     * @return Feature
     * @see about_url
     */
    public function setAboutUrl(string $about_url): Feature
    {
        $this->about_url = $about_url;
        return $this;
    }


    /**
     * @inheritDoc
     * @return array
     */
    #[Override] public function jsonSerialize(): array
    {
        return array(
            "type" => $this->type,
            "geometry_name" => $this->geometry_name,
            "geometry" => $this->geometry,
            "properties" => array(
                "source_id" => $this->id,
                "tooltip_content" => $this->tooltip_content,
                "about_url" => $this->about_url
            ),
            "tooltip_content" => $this->tooltip_content
        );
    }


}