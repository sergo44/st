<?php

namespace St\Sights\Views\ShowSights;

use Override;
use St\Sights\Sight;
use St\Views\HtmlView;
use St\Views\IView;

class ShowSightsHtmlView extends HtmlView implements IView
{
    /**
     * Достопримечательности для отображения
     * @var Sight[]
     */
    protected array $sights;

    /**
     * @inheritdoc
     * @return void
     */
    #[Override] public function out(): void
    {
        ?>

        <?php
    }

}