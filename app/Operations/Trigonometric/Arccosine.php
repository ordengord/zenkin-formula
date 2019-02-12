<?php

namespace App\Operations\Trigonometric;

use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class Arccosine
 * @package App\Operations\Trigonometric
 */
class Arccosine extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'arccos';

    /**
     * @param Variable $variableOne
     * @return float
     */
    public function calculate(Variable $variableOne)
    {
        return acos($variableOne->getValue());
    }
}