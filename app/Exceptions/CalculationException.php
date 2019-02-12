<?php

namespace App\Exceptions;

class CalculationException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Check as there might a misprint in your formula");
    }

}