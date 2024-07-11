<?php

namespace St\Catalog\Views\EditObject;

use St\Views\IView;
use St\Views\JsonView;

class RemoveRoomJsonView extends JsonView implements IView, \JsonSerializable
{

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult()
        );
    }
}