<?php

namespace St\Catalog\Views\ObjectsMap;

use St\Ol\FeatureCollection;
use St\Views\HtmlView;
use St\Views\IView;

class ObjectsMapHtmlView extends HtmlView implements IView
{
    /**
     * Широта центра карты
     * @var float|null
     */
    protected ?float $lat = null;
    /**
     * Долгота центра карты
     * @var float|null
     */
    protected ?float $lon = null;
    /**
     * Zoom
     * @var int|null
     */
    protected ?int $zoom = null;

    /**
     * Коллекцию, которую необходимо отобразить
     * @var FeatureCollection
     */
    protected FeatureCollection $feature_collection;

    /**
     * Возвращает feature_collection
     * @return FeatureCollection
     * @see feature_collection
     */
    public function getFeatureCollection(): FeatureCollection
    {
        return $this->feature_collection;
    }

    /**
     * Устанавливает feature_collection
     * @param FeatureCollection $feature_collection
     * @return ObjectsMapHtmlView
     * @see feature_collection
     */
    public function setFeatureCollection(FeatureCollection $feature_collection): ObjectsMapHtmlView
    {
        $this->feature_collection = $feature_collection;
        return $this;
    }

    /**
     * Устанавливает центр карты
     * @param float $lat
     * @param float $lon
     * @return $this
     */
    public function setCenter(float $lat, float $lon): self
    {
        $this->lat = $lat;
        $this->lon = $lon;
        return $this;
    }

    /**
     * Устанавливает zoom
     * @param int|null $zoom
     * @return ObjectsMapHtmlView
     * @see zoom
     */
    public function setZoom(?int $zoom): ObjectsMapHtmlView
    {
        $this->zoom = $zoom;
        return $this;
    }



    /**
     * @inheritDoc
     * @return void
     */
    #[\Override] public function out(): void
    {
        ?>
        <style>
            #catalogObjectsMap {
                width: 100%;
                height: 600px;
                position: relative;
            }

            #info {
                position: absolute;
                display: inline-block;
                height: auto;
                width: auto;
                z-index: 100;
                background-color: #333;
                color: #fff;
                text-align: center;
                border-radius: 4px;
                padding: 5px;
                left: 50%;
                transform: translateX(3%);
                visibility: hidden;
                pointer-events: none;
            }
        </style>

        <script>
const objectsMapFeatures = <?php print json_encode($this->getFeatureCollection(), JSON_PRETTY_PRINT)?>;
<?php if ($this->lat && $this->lon):?>
const jCenterMap = <?php print json_encode(array($this->lat, $this->lon)); ?>;
<?php endif; ?>
<?php if ($this->zoom):?>
const jMapZoom = <?php print json_encode($this->zoom); ?>;
<?php endif; ?>
        </script>

        <div id="catalogObjectsMap" class="mt-3">
            <div id="info"></div>
        </div>
        <?php
    }

}