<?php

namespace App\Exceptions;

class InvalidFormulaException extends \InvalidArgumentException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}