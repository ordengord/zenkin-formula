<?php

namespace App\Operations\Trigonometric;

use App\Errors\TangentError;
use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class Tangent
 * @package App\Operations\Trigonometric
 */
class Tangent extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'tg';

    /**
     * @param Variable $variableOne
     * @return float
     * @throws TangentError
     */
    public function calculate(Variable $variableOne)
    {
        if (cos($variableOne->getValue()))
            return tan($variableOne->getValue());

        throw new TangentError();
    }

}