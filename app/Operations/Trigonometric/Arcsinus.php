<?php

namespace App\Operations\Trigonometric;

use App\Operations\OneVariableOperation;
use App\Variable;

/**
 * Class Arcsinus
 * @package App\Operations\Trigonometric
 */
class Arcsinus extends OneVariableOperation
{
    /**
     * @var int
     */
    protected $priority = 2;

    /**
     * @var string
     */
    protected $symbol = 'arcsin';

    /**
     * @param Variable $variableOne
     * @return float
     */
    public function calculate(Variable $variableOne)
    {
        return asin($variableOne->getValue());
    }
}