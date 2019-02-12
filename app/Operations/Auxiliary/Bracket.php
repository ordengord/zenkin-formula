<?php

namespace App\Operations\Auxiliary;

use App\Interfaces\FormulaComponent;

/**
 * Class Bracket
 * @package App\Operations\Auxiliary
 */
abstract class Bracket implements FormulaComponent
{
    /**
     * @var string
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
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}