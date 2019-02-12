<?php

namespace App\Operations\Auxiliary;

class LeftBracket extends Bracket
{
    /**
     * @var int
     */
    protected $priority = -1;

    /**
     * @var string
     */
    protected $symbol = '(';

}