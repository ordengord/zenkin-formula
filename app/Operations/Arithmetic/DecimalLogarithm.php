<?php

namespace App\Operations\Arithmetic;

use App\Operations\OneVariableOperation;
use App\Variable;
use App\Errors\LogarithmError;

/**
 * Class DecimalLogarithm
 * @package App\Operations\Arithmetic
 */
class DecimalLogarithm extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'lg';

    /**
     *
     * @param Variable $variableOne
     * @return float
     * @throws  LogarithmError
     */
    public function calculate(Variable $variableOne)
    {
        if ($variableOne->getValue() > 0)
            return log10($variableOne->getValue());

        throw new LogarithmError();
    }

}