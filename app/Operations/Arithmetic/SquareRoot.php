<?php

namespace App\Operations\Arithmetic;

use App\Operations\OneVariableOperation;
use App\Errors\SquareRootError;
use App\Variable;

/**
 * Class SquareRoot
 * @package App\Operations\Arithmetic
 */
class SquareRoot extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'sqrt';

    /**
     * @param Variable $variableOne
     * @return float
     * @throws SquareRootError
     */
    public function calculate(Variable $variableOne)
    {
        if ($variableOne->getValue() >= 0)
            return sqrt($variableOne->getValue());

        throw new SquareRootError();
    }
}