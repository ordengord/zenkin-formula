<?php

namespace App\Operations\Arithmetic;

use App\Variable;
use App\Operations\TwoVariableOperation;

/**
 * Class Divide
 * @package App\Operations\Arithmetic
 */
class Divide extends TwoVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 1;

    /**
     * @var string
     */
    protected $symbol = '/';

    /**
     * @param Variable $variableOne
     * @param Variable $variableTwo
     * @return float
     * @throws \DivisionByZeroError
     */
    public function calculate(Variable $variableOne, Variable $variableTwo)
    {
        if ($variableTwo->getValue())
            return $variableOne->getValue() / $variableTwo->getValue();

        throw new \DivisionByZeroError('Division by zero error!');
    }
}