<?php

namespace App\Operations\Trigonometric;

use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class Arccotangent
 * @package App\Operations\Trigonometric
 */
class Arccotangent extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'arcctg';

    /**
     * @param Variable $variableOne
     * @return float
     */
    public function calculate(Variable $variableOne)
    {
        $acos = acos($variableOne->getValue() / (sqrt(1 + $variableOne->getValue() * $variableOne->getValue())));
        return $variableOne->getValue() >= 0 ? $acos : (pi() + $acos);
    }

}