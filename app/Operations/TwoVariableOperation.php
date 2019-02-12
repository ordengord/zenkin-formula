<?php

namespace App\Operations;

use App\Variable;

/**
 * Class TwoVariableOperation
 *
 * @package App\Operations
 */

abstract class TwoVariableOperation extends VariableOperation
{
    /**
     * @param Variable $variableOne
     * @param Variable $variableTwo
     */
    public function calculate(Variable $variableOne, Variable $variableTwo){}
}