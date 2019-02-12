<?php

namespace App\Operations\Arithmetic;

use App\Variable;
use App\Operations\TwoVariableOperation;

/**
 * Class Plus
 * @package App\Operations\Arithmetic
 */
class Plus extends TwoVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 0;

    /**
     * @var string
     */
    protected $symbol = '+';

    /**
     * @param Variable $variableOne
     * @param Variable $variableTwo
     * @return float
     */
    public function calculate(Variable $variableOne, Variable $variableTwo)
    {
        return $variableOne->getValue() + $variableTwo->getValue();
    }

}