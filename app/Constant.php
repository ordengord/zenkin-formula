<?php

namespace App;

/**
 * Class Constant
 * @package App
 */
class Constant extends Variable
{
    /**
     * Constant constructor.
     * @param $symbol
     */
    public function __construct($symbol)
    {
        parent::__construct($symbol);
        $this->value = $symbol;
    }
}