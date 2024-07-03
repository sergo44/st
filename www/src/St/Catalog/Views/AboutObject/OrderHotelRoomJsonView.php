<?php

namespace St\Catalog\Views\AboutObject;

use St\Views\IView;
use St\Views\JsonView;

class OrderHotelRoomJsonView extends JsonView implements IView, \JsonSerializable
{

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult()
        );
    }
}