<?php

namespace App\Exceptions;

class CalculationException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Check as there might be a misprint in your formula");
    }

}