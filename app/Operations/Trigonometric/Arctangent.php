<?php

namespace App\Operations\Trigonometric;

use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class Arctangent
 * @package App\Operations\Trigonometric
 */
class Arctangent extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'arctg';

    /**
     * @param Variable $variableOne
     * @return float
     */
    public function calculate(Variable $variableOne)
    {
        return atan($variableOne->getValue());
    }

}