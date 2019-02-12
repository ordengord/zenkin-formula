<?php

namespace App\Errors;

class SquareRootError extends \ArithmeticError
{
    public function __construct()
    {
        parent::__construct("The number under square root is zero or less");
    }

}