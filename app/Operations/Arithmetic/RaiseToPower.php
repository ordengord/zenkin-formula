<?php

namespace App\Operations\Arithmetic;

use App\Variable;
use App\Operations\TwoVariableOperation;

/**
 * Class RaiseToPower
 * @package App\Operations\Arithmetic
 */
class RaiseToPower extends TwoVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = '^';

    /**
     * @param Variable $variableOne
     * @param Variable $variableTwo
     * @return float|int
     */
    public function calculate(Variable $variableOne, Variable $variableTwo)
    {
        return pow($variableOne->getValue(), $variableTwo->getValue());
    }
}