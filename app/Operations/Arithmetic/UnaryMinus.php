<?php

namespace App\Operations\Arithmetic;

use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class UnaryMinus
 * @package App\Operations\Arithmetic
 */
class UnaryMinus extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = '-';

    /**
     * @param Variable $variableOne
     * @return float
     */
    public function calculate(Variable $variableOne)
    {
        return -$variableOne->getValue();
    }
}