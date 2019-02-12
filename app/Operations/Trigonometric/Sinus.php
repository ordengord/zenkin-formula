<?php

namespace App\Operations\Trigonometric;

use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class Sinus
 * @package App\Operations\Trigonometric
 */
class Sinus extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'sin';

    /**
     * @param Variable $variableOne
     * @return float
     */
    public function calculate(Variable $variableOne)
    {
        return sin($variableOne->getValue());
    }
}