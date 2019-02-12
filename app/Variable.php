<?php

namespace App;

use App\Interfaces\FormulaComponent;

/**
 * Class Variable
 * @package App
 */
class Variable implements FormulaComponent
{
    /**
     * @var float
     */
    protected $value;

    /**
     * @var string
     */
    protected $symbol;

    /**
     * @param string $symbol
     */
    public function __construct($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param float
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->symbol;
    }
}