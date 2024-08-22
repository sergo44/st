<?php

namespace St\Views\Common;

use JsonSerializable;
use St\Views\IView;
use St\Views\JsonView;

class ResultJsonView extends JsonView  implements JsonSerializable, IView
{
    /**
     * @inheritDoc
     * @return array
     */
    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult()
        );
    }
}