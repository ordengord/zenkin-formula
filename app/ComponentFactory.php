<?php

namespace App;

use App\Interfaces\FormulaComponent;
use App\Operations\Arithmetic\DecimalLogarithm;
use App\Operations\Arithmetic\NaturalLogarithm;
use App\Operations\Arithmetic\SquareRoot;
use App\Operations\Arithmetic\UnaryMinus;
use App\Operations\Trigonometric\Arccosine;
use App\Operations\Trigonometric\Arccotangent;
use App\Operations\Trigonometric\Arcsinus;
use App\Operations\Trigonometric\Arctangent;
use App\Operations\Trigonometric\Cosine;
use App\Operations\Trigonometric\Cotangent;
use App\Operations\Trigonometric\Sinus;
use App\Operations\Trigonometric\Tangent;
use App\Operations\Arithmetic\Plus;
use App\Operations\Arithmetic\Minus;
use App\Operations\Arithmetic\Divide;
use App\Operations\Arithmetic\Multiply;
use App\Operations\Arithmetic\RaiseToPower;
use App\Operations\Auxiliary\LeftBracket;
use App\Operations\Auxiliary\RightBracket;

/**
 * Class ComponentFactory
 *
 * @package App
 */
abstract class ComponentFactory
{

    /**
     * @param string $symbol
     * @param bool $unaryMinusPossibility
     * @return FormulaComponent
     */
    public static function createNewComponent($symbol, $unaryMinusPossibility = false)
    {
        switch ($symbol) {
            case '+':
                return new Plus();
            case '-':
                return $unaryMinusPossibility ? new UnaryMinus() : new Minus();
            case '*':
                return new Multiply();
            case '/':
                return new Divide();
            case '^':
                return new RaiseToPower();
            case 'sqrt':
                return new SquareRoot();
            case 'ln':
                return new NaturalLogarithm();
            case 'lg':
                return new DecimalLogarithm();
            case 'sin':
                return new Sinus();
            case 'cos':
                return new Cosine();
            case 'tg':
                return new Tangent();
            case 'ctg':
                return new Cotangent();
            case 'arcsin':
                return new Arcsinus();
            case 'arccos':
                return new Arccosine();
            case 'arctg':
                return new Arctangent();
            case 'arcctg':
                return new Arccotangent();
            case '(':
                return new LeftBracket();
            case ')':
                return new RightBracket();
            default:
                is_numeric($symbol) ? $variable = new Constant($symbol) : $variable = new Variable ($symbol);
                return $variable;
        }
    }
}