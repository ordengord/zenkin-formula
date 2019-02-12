<?php

namespace App\Errors;

class LogarithmError extends \ArithmeticError
{
    public function __construct()
    {
        parent::__construct("The number under logarithm is zero or less");
    }
}