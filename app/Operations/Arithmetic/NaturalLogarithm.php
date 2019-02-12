<?php

namespace App\Operations\Arithmetic;

use App\Operations\OneVariableOperation;
use App\Variable;
use App\Errors\LogarithmError;

/**
 * Class NaturalLogarithm
 * @package App\Operations\Arithmetic
 */
class NaturalLogarithm extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'ln';

    /**
     * @param Variable $variableOne
     * @return float
     * @throws LogarithmError
     */
    public function calculate(Variable $variableOne)
    {
        if ($variableOne->getValue() > 0)
            return log($variableOne->getValue());

        throw new LogarithmError();
    }
}