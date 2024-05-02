<?php

namespace St;

class ErrorResult extends Result
{
    public function __construct(string $message)
    {
        $this->addError($message);
    }
}