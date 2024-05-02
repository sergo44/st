<?php

namespace St\StaticContent\Views\Index;

use St\Views\HtmlView;
use St\Views\IView;

class IndexContentHtmlView extends HtmlView implements IView
{
    public function out(): void
    {
        ?>

        <?php
    }
}