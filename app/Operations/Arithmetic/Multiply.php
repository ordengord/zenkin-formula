<?php

namespace App\Operations\Arithmetic;

use App\Variable;
use App\Operations\TwoVariableOperation;

/**
 * Class Multiply
 * @package App\Operations\Arithmetic
 */
class Multiply extends TwoVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 1;

    /**
     * @var string
     */
    protected $symbol = '*';

    /**
     * @param Variable $variableOne
     * @param Variable $variableTwo
     * @return float|int
     */
    public function calculate(Variable $variableOne, Variable $variableTwo)
    {
        return $variableOne->getValue() * $variableTwo->getValue();
    }
}