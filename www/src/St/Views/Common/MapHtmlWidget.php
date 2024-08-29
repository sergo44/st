<?php

namespace St\Views\Common;

use St\Catalog\CallableControllers\ObjectsMapController;
use St\Catalog\Views\ObjectsMap\ObjectsMapHtmlView;
use St\Layouts\HtmlLayout;
use St\Views\HtmlView;
use St\Views\IView;

class MapHtmlWidget extends HtmlView implements IView
{
    /**
     * @var float
     */
    protected float $lat;
    /**
     * @var float
     */
    protected float $lon;

    /**
     * @param float $lat
     * @param float $lon
     */
    public function __construct(float $lat, float $lon)
    {
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * Отображаем карту
     * @return void
     */
    public function out(): void
    {
        $entity = (new ObjectsMapController(
            $_REQUEST,
            $layout = new HtmlLayout(),
            $view = new ObjectsMapHtmlView()
        ))->index( $this->lat, $this->lon );

        $view
            ->setCenter($this->lat, $this->lon)
            ->setZoom(12)
            ;

        $entity->getView()->out();
    }
}