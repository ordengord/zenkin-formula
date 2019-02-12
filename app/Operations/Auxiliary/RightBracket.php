<?php

namespace App\Operations\Auxiliary;

/**
 * Class RightBracket
 * @package App\Operations\Auxiliary
 */
class RightBracket extends Bracket
{
    /**
     * @var int
     */
    protected $priority = -1;

    /**
     * @var string
     */
    protected $symbol = ')';

}