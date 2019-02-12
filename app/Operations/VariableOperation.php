<?php

namespace App\Operations;

use App\Interfaces\FormulaComponent;

/**
 * Class VariableOperation
 * @package App\Operations
 */
abstract class VariableOperation implements FormulaComponent
{
    /**
     * @var string part of operation -
     */
    protected $symbol;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Increases priority by value (when there are brackets in expression)
     *
     * @param int $value
     */
    public function increasePriority($value)
    {
        $this->priority += $value;
    }
}