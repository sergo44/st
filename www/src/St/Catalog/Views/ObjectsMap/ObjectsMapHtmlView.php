<?php

namespace St\Catalog\Views\ObjectsMap;

use St\Ol\FeatureCollection;
use St\Views\HtmlView;
use St\Views\IView;

class ObjectsMapHtmlView extends HtmlView implements IView
{
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
     * @inheritDoc
     * @return void
     */
    #[\Override] public function out(): void
    {
        ?>
        <style>
            .map {
                width: 100%;
                height: 400px;
            }
        </style>

        <script>
const objectsMapFeatures = <?php print json_encode($this->getFeatureCollection(), JSON_PRETTY_PRINT)?>;
        </script>

        <div id="catalogObjectsMap" class="map"></div>
        <?php
    }

}