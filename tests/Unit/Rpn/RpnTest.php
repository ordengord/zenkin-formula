<?php

namespace Tests\Unit\Rpn;

use PHPUnit\Framework\TestCase;
use App\Formula;
use App\Exceptions\InvalidFormulaException;

class RpnTest extends TestCase
{
    public function test_an_easy_string_can_be_reversed_properly()
    {
        $str = 'A+B';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'AB+');
    }

    public function test_several_plus_operations_also_can_be_executed()
    {
        $str = 'A + B+C+D';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'AB+C+D+');
    }

    public function test_it_can_reverse_arithmetic_expressions_without_brackets()
    {
        $str = 'A+B*C-D/4';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'ABC*+D4/-');
        $this->assertEquals(count($expr->getVariables()), 5);
    }

    public function test_multiply_divide_and_pow_reverse()
    {
        $str = 'A*B^C';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'ABC^*');
    }

    public function test_some_other_scenarios_without_brackets1()
    {
        $str1 = 'A+B * 4 ^C - A^3*2';
        $expr = new Formula($str1);
        $this->assertEquals($expr->getInfix(), 'A+B*4^C-A^3*2');
        $this->assertEquals($expr, 'AB4C^*+A3^2*-');
    }

    public function test_some_other_scenarios_without_brackets2()
    {
        $str = 'A*B/C^3-D*E^F^4';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'AB*C3^/DEF^4^*-');
    }

    public function test_some_other_scenarios_without_brackets3()
    {
        $str = 'A-B/C+2^D*3-4/E';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'ABC/-2D^3*+4E/-');
    }

    public function test_easy_bracket()
    {
        $str = 'C*(A+B)';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'CAB+*');
    }

    public function test_difficult_bracket()
    {
        $str = 'C*(A+B)^2/(D*(E+F*G))';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'CAB+2^*DEFG*+*/');
    }

    public function test_very_difficult_bracket()
    {
        $str = 'A * 2^(B+3*C)/(D+(4*E)^(G-F/3))';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'A2B3C*+^*D4E*GF3/-^+/');
    }

    public function test_unary_minus_update()
    {
        $str = '-A + B -C *(-E)';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'A-B+CE-*-');
    }

    /**
     * @expectedException InvalidFormulaException
     * @expectedExceptionMessage  "There are excessive left brackets in the formula"
     * @return void
     */
    public function test_left_bracket_is_one_more_in_expression()
    {
        $str = 'A+(-B *C)^((D-4)';
        $expr = new Formula($str);
    }

    public function test_logarithms_and_trig_operations()
    {
        $str = 'ln2*arcsinx+4/tgA*(sqrtB-5*(2-z))';
        $expr = new Formula($str);
        $this->assertEquals($expr, '2lnxarcsin*4Atg/Bsqrt52z-*-*+');
    }

    public function test_difficult_logarithms_and_trig_operations()
    {
        $str = 'ln^2(arcsinx)+4/tgA*(sqrtB-5*(2-lgC^(cos(y+z))))';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'ln2xarcsin^4Atg/Bsqrt52Clgyz+cos^-*-*+');
    }

}