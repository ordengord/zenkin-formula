<?php

namespace Tests\Unit\Operation;

use App\Errors\LogarithmError;
use PHPUnit\Framework\TestCase;
use App\Variable;
use App\Constant;
use App\Operations\Arithmetic\DecimalLogarithm;
use App\Operations\Arithmetic\NaturalLogarithm;
use App\Operations\Arithmetic\SquareRoot;
use App\Operations\Arithmetic\UnaryMinus;
use App\Operations\Arithmetic\Plus;
use App\Operations\Arithmetic\Minus;
use App\Operations\Arithmetic\Divide;
use App\Operations\Arithmetic\Multiply;
use App\Operations\Arithmetic\RaiseToPower;

// Trigonometry to be tested later
class OperationTest extends TestCase
{
    private $one, $two, $three, $four, $five, $six;
    
    public function setUp()
    {
        $this->one = new Constant(-2);
        $this->two = new Variable('x');
        $this->two->setValue(0.5);
        $this->three = new Constant(0);
        $this->four = new Constant(1);
        $this->five = new Variable('y');
        $this->five->setValue(16);
        $this->six = new Constant(100);
        parent::setUp();
    }

    /**
     * @test
     */
    public function calculate()
    {
        $plus = new Plus;
        $minus = new Minus;
        $multiply = new Multiply;
        $divide = new Divide;
        $pow = new RaiseToPower;
        $unary = new UnaryMinus;
        $sqrt = new SquareRoot;
        $decimal = new DecimalLogarithm;
        $natural = new NaturalLogarithm;
        $this->assertEquals($plus->calculate($this->one, $this->two), -1.5);
        $this->assertEquals($minus->calculate($this->one, $this->four), -3);
        $this->assertEquals($multiply->calculate($this->one, $this->two), -1);
        $this->assertEquals($divide->calculate($this->four, $this->two), 2);
        $this->assertEquals($pow->calculate($this->two, $this->one), 4);
        $this->assertEquals($unary->calculate($this->two), -0.5);
        $this->assertEquals($sqrt->calculate($this->five), 4);
        $this->assertEquals($decimal->calculate($this->six), 2);
        $this->assertEquals($natural->calculate($this->four), 0);
    }

    /**
     * @test
     * @expectedException \DivisionByZeroError
     */
    public function division_by_zero()
    {
        $divide = new Divide;
        $result = $divide->calculate($this->two, $this->three);
    }

    /**
     * @expectedException LogarithmError
     * @test
     */

    public function logarithm_error()
    {
        $natural = new NaturalLogarithm;
        $result = $natural->calculate($this->one);
    }

}