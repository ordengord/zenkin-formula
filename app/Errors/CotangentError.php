<?php


namespace App\Errors;


class CotangentError extends \ArithmeticError
{
    public function __construct()
    {
        parent::__construct("Cannot calculate cotangent when sinus is equal to 0");
    }
}