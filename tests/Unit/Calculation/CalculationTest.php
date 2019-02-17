<?php

namespace Tests\Unit\Calculation;

use PHPUnit\Framework\TestCase;

use App\Formula;
use App\Calculator;

class CalculationTest extends TestCase
{
    public function test_simple()
    {
        $str = 'A+B';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, 'AB+');
        $expr->setValues (['A' => 2, 'B' => 4]);
        $this->assertEquals($expr->calculate(), 6);

    }


    public function test_simple_formula_without_negative_variables()
    {
        $str = 'A+B*C-D/E';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, 'ABC*+DE/-');
        $expr->setValues (['A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 2]);
        /*$expr->setVariableValue($expr->findVariableByName('A'), 1);
        $expr->setVariableValue($expr->findVariableByName('B'), 2);
        $expr->setVariableValue($expr->findVariableByName('C'), 3);
        $expr->setVariableValue($expr->findVariableByName('D'), 4);
        $expr->setVariableValue($expr->findVariableByName('E'), 2);*/
        $this->assertEquals($expr->calculate(), 5);

        return $expr;
    }

    /**
     * @depends test_simple_formula_without_negative_variables
     * @param Formula $expr
     */
    public function test_it_can_calculate_with_different_sets_of_values(Formula $expr)
    {
        $expr->setValues (['A' => 6, 'B' => 4, 'C' => 8, 'D' => 3, 'E' => 5]);
        $this->assertEquals($expr->calculate(), 37.4);

        $expr->setValues (['A' => -1, 'B' => 2, 'C' => 4, 'D' => 10, 'E' => 2]);
        $this->assertEquals($expr->calculate(), 2);

    }

    public function test_formula_without_negative_and_repeated_variables()
    {
        $str = 'AE +B*C - D/(F*cosx)+ G^HI';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, 'AEBC*+DFxcos*/-GHI^+');
        $expr->setValues (['AE' => 1, 'B' => 3, 'C' => 2, 'D' => 10, 'F' => 2, 'x' => 0, 'G' => 3, 'HI' => 2]);

        /*$expr->setVariableValue($expr->findVariableByName('AE'), 1);
        $expr->setVariableValue($expr->findVariableByName('B'), 3);
        $expr->setVariableValue($expr->findVariableByName('C'), 2);
        $expr->setVariableValue($expr->findVariableByName('D'), 10);
        $expr->setVariableValue($expr->findVariableByName('F'), 2);
        $expr->setVariableValue($expr->findVariableByName('x'), 0);
        $expr->setVariableValue($expr->findVariableByName('G'), 3);
        $expr->setVariableValue($expr->findVariableByName('HI'), 2);*/
        $this->assertEquals($expr->calculate(), 11);
    }

    public function test_almost_as_previous()
    {
        $str = 'AE +B*C^2 - D/(F*cosx)+ 20*G^(4/HI)';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, 'AEBC2^*+DFxcos*/-20G4HI/^*+');
        $expr->setValues (['AE' => 1, 'B' => 3, 'C' => 2, 'D' => 10, 'F' => 2, 'x' => 0, 'G' => 3, 'HI' => 2]);
        /*$expr->setVariableValue($expr->findVariableByName('AE'), 1);
        $expr->setVariableValue($expr->findVariableByName('B'), 3);
        $expr->setVariableValue($expr->findVariableByName('C'), 2);
        $expr->setVariableValue($expr->findVariableByName('D'), 10);
        $expr->setVariableValue($expr->findVariableByName('F'), 2);
        $expr->setVariableValue($expr->findVariableByName('x'), 0);
        $expr->setVariableValue($expr->findVariableByName('G'), 3);
        $expr->setVariableValue($expr->findVariableByName('HI'), 2);*/
        $this->assertEquals($expr->calculate(), 188);
    }

    public function test_difficult_calculation_with_repeating_and_composite_variables()
    {
        $expr = new Formula('A+B^(sin(CH3)/CH4) - AE5+ (2+cosCH3)*lg(C)/ (5^(2+arctg(AE5)))');
        $expr->convert();
        $this->assertEquals($expr, 'ABCH3sinCH4/^+AE5-2CH3cos+Clg*52AE5arctg+^/+');
        $expr->setValues (['A' => -10, 'B' => 16, 'CH3' => M_PI_2, 'C' => 100, 'CH4' => 2, 'AE5' => 0]);
        /*$expr->setVariableValue($expr->findVariableByName('A'), -10);
        $expr->setVariableValue($expr->findVariableByName('B'), 16);
        $expr->setVariableValue($expr->findVariableByName('CH3'), M_PI_2);
        $expr->setVariableValue($expr->findVariableByName('C'), 100);
        $expr->setVariableValue($expr->findVariableByName('CH4'), 2);
        $expr->setVariableValue($expr->findVariableByName('AE5'), 0);*/
        $this->assertEquals($expr->calculate(), -5.84);//-10 + 4 - 0 + 2*2 / 5^2 == -6 + 0.16
    }

    public function test_formula_including_division_by_zero_error()
    {
        $str = '2*x^2/(y-4)';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, '2x2^*y4-/');
        $expr->setValues (['x' => 2, 'y' => 4]);
        $calc = new Calculator($expr);
        $this->assertEquals($calc->calculate(), 'Division by zero error!');
        /*$expr->setVariableValue($expr->findVariableByName('x'), 2);
        $expr->setVariableValue($expr->findVariableByName('y'), 4);*/
    }

    public function test_calculation_including_value_equal_or_less_zero_in_logarithm()
    {
        $str = 'x*ln(13 - 7*A + B)';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, 'x137A*-B+ln*');
        $expr->setValues(['x' => 8, 'A' => 2, 'B' => 1]);
        $this->assertEquals($expr->calculate(), "The number under logarithm is zero or less");

        /*$expr->setVariableValue($expr->findVariableByName('x'), 8);
        $expr->setVariableValue($expr->findVariableByName('A'), 2);
        $expr->setVariableValue($expr->findVariableByName('B'), 1);*/
    }

    public function test_too_many_operations_in_formula()
    {
        $str = 'A+(-B *C)^(D-4)++';
        $expr = new Formula($str);
        $expr->convert();
        $this->assertEquals($expr, 'AB-C*D4-^+++'); // RPN converter is supposed to work correctly
        $expr->setValues(['A' => 8, 'B' => -1, 'C' => 3, 'D' => 6]);

        /*$expr->setVariableValue($expr->findVariableByName('A'), 8);
        $expr->setVariableValue($expr->findVariableByName('B'), -1);
        $expr->setVariableValue($expr->findVariableByName('C'), 3);
        $expr->setVariableValue($expr->findVariableByName('D'), 6);*/

        $this->assertEquals($expr->calculate(), "Check as there might be a misprint in your formula");

    }



}