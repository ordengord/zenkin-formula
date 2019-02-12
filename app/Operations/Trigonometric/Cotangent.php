<?php

namespace App\Operations\Trigonometric;

use App\Operations\OneVariableOperation;
use App\Variable;
use App\Errors\CotangentError;

/**
 * Class Cotangent
 * @package App\Operations\Trigonometric
 */
class Cotangent extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'ctg';

    /**
     * @param Variable $variableOne
     * @return float
     * @throws CotangentError
     */
    public function calculate(Variable $variableOne)
    {
        if (sin($variableOne->getValue()))
            return tan(M_PI_2 - rad2deg($variableOne->getValue()));

        throw new CotangentError();
    }
}