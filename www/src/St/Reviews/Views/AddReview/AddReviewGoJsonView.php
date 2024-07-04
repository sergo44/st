<?php

namespace St\Reviews\Views\AddReview;

use St\Views\IView;
use St\Views\JsonView;

class AddReviewGoJsonView extends JsonView implements IView, \JsonSerializable
{

    #[\Override] public function jsonSerialize(): array
    {
        return array(
            "result" => $this->getResult()
        );
    }
}