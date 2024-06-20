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
        </script>

        <div id="catalogObjectsMap">
            <div id="info"></div>
        </div>
        <?php
    }

}