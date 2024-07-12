<?php

namespace St\Catalog\Views\EditObject;

use St\Views\IView;
use St\Views\JsonView;

class PurgeImageJsonView extends JsonView implements \JsonSerializable, IView
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