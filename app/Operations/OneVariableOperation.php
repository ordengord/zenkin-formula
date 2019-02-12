<?php

namespace App\Operations;

use App\Variable;

/**
 * Class OneVariableOperation
 *
 * @package App\Operations
 */
abstract class OneVariableOperation extends VariableOperation
{
    /**
     * @param Variable $variableOne
     */
    public function calculate(Variable $variableOne){}
}