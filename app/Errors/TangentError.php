<?php


namespace App\Errors;


class TangentError extends \ArithmeticError
{
    public function __construct()
    {
        parent::__construct("Cannot calculate tangent when cosine is equal to 0");
    }
}