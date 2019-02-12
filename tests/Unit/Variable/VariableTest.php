<?php

namespace Tests\Unit\Variable;

use PHPUnit\Framework\TestCase;
use App\Variable;
use App\Constant;


class VariableTest extends TestCase
{
    /**
     * @test
     */
    public function create_variables()
    {
        $var = new Variable('AB');
        $this->assertEquals($var->getSymbol(), 'AB');
        $this->assertNull($var->getValue());
    }

    /**
     * @test
     */
    public function create_constant()
    {
        $var = new Constant(315);
        $this->assertEquals($var->getValue(), 315);
        $this->assertEquals($var->getSymbol(), '315');
    }

    /**
     * @test
     */
    public function set_variable_value()
    {
        $var = new Variable('x');
        $var->setValue(15);
        $this->assertEquals(15, $var->getValue());
    }
}
