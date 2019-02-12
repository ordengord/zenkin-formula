<?php

namespace Tests\Unit\Calculation;

use PHPUnit\Framework\TestCase;

use App\Formula;

class CalculationTest extends TestCase
{
    public function test_simple_expression_without_negative_variables()
    {
        $str = 'A+B*C-D/E';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'ABC*+DE/-');
        $expr->setVariableValue($expr->findVariableByName('A'), 1);
        $expr->setVariableValue($expr->findVariableByName('B'), 2);
        $expr->setVariableValue($expr->findVariableByName('C'), 3);
        $expr->setVariableValue($expr->findVariableByName('D'), 4);
        $expr->setVariableValue($expr->findVariableByName('E'), 2);
        $this->assertEquals($expr->calculate(), 5);
    }

    public function test_expression_without_negative_and_repeated_variables()
    {
        $str = 'AE +B*C - D/(F*cosx)+ G^HI';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'AEBC*+DFxcos*/-GHI^+');
        $expr->setVariableValue($expr->findVariableByName('AE'), 1);
        $expr->setVariableValue($expr->findVariableByName('B'), 3);
        $expr->setVariableValue($expr->findVariableByName('C'), 2);
        $expr->setVariableValue($expr->findVariableByName('D'), 10);
        $expr->setVariableValue($expr->findVariableByName('F'), 2);
        $expr->setVariableValue($expr->findVariableByName('x'), 0);
        $expr->setVariableValue($expr->findVariableByName('G'), 3);
        $expr->setVariableValue($expr->findVariableByName('HI'), 2);
        $this->assertEquals($expr->calculate(), 11);
    }

    public function test_expression_without_negative_variables_and_repeated_variables()
    {
        $str = 'AE +B*C^2 - D/(F*cosx)+ 20*G^(4/HI)';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'AEBC2^*+DFxcos*/-20G4HI/^*+');
        $expr->setVariableValue($expr->findVariableByName('AE'), 1);
        $expr->setVariableValue($expr->findVariableByName('B'), 3);
        $expr->setVariableValue($expr->findVariableByName('C'), 2);
        $expr->setVariableValue($expr->findVariableByName('D'), 10);
        $expr->setVariableValue($expr->findVariableByName('F'), 2);
        $expr->setVariableValue($expr->findVariableByName('x'), 0);
        $expr->setVariableValue($expr->findVariableByName('G'), 3);
        $expr->setVariableValue($expr->findVariableByName('HI'), 2);
        $this->assertEquals($expr->calculate(), 188);
    }

    public function test_difficult_calculation_with_repeating_and_composite_variables()
    {
        $expr = new Formula('A+B^(sin(CH3)/CH4) - AE5+ (2+cosCH3)*lg(C)/ (5^(2+arctg(AE5)))');
        $this->assertEquals($expr, 'ABCH3sinCH4/^+AE5-2CH3cos+Clg*52AE5arctg+^/+');
        $expr->setVariableValue($expr->findVariableByName('A'), -10);
        $expr->setVariableValue($expr->findVariableByName('B'), 16);
        $expr->setVariableValue($expr->findVariableByName('CH3'), M_PI_2);
        $expr->setVariableValue($expr->findVariableByName('C'), 100);
        $expr->setVariableValue($expr->findVariableByName('CH4'), 2);
        $expr->setVariableValue($expr->findVariableByName('AE5'), 0);
        $this->assertEquals($expr->calculate(), -5.84);//-10 + 4 - 0 + 2*2 / 5^2 == -6 + 0.16
    }

    /**
     * @expectedExceptionMessage "The number under logarithm is zero or less"
     */
    public function test_expression_including_division_by_zero_error()
    {
        $str = '2*x^2/(y-4)';
        $expr = new Formula($str);
        $this->assertEquals($expr, '2x2^*y4-/');
        $expr->setVariableValue($expr->findVariableByName('x'), 2);
        $expr->setVariableValue($expr->findVariableByName('y'), 4);
    }

    /**
     * @expectedExceptionMessage "The number under logarithm is zero or less"
     */
    public function test_calculation_including_value_equal_or_less_zero_in_logarithm()
    {
        $str = 'x*ln(13 - 7*A + B)';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'x137A*-B+ln*');
        $expr->setVariableValue($expr->findVariableByName('x'), 8);
        $expr->setVariableValue($expr->findVariableByName('A'), 2);
        $expr->setVariableValue($expr->findVariableByName('B'), 1);
    }

    /**
     * @expectedException CalculationException
     * @expectedExceptionMessage  Check as there might a misprint in your formula
     */
    public function test_too_many_operations_in_expression()
    {
        $str = 'A+(-B *C)^(D-4)++';
        $expr = new Formula($str);
        $this->assertEquals($expr, 'AB-C*D4-^+++'); // RPN converter should work correctly
        $expr->setVariableValue($expr->findVariableByName('A'), 8);
        $expr->setVariableValue($expr->findVariableByName('B'), -1);
        $expr->setVariableValue($expr->findVariableByName('C'), 3);
        $expr->setVariableValue($expr->findVariableByName('D'), 6);
        $result = $expr->calculate();

    }

}