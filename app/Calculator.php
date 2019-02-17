<?php

namespace App;

use App\Exceptions\CalculationException;
use App\Operations\TwoVariableOperation;
use App\Operations\OneVariableOperation;

/**
 * Class Calculator
 * @package App
 */
class Calculator
{
    /**
     * @var \App\Formula
     */
    protected $formula;

    /**
     * Calculator constructor.
     * @param Formula $formula
     */
    public function __construct(Formula $formula)
    {
        $this->formula = $formula;
    }

    /**
     * @return string | float
     */
    public function calculate()
    {
        $calculator = [];

        try {
            foreach ($this->formula->getPostfix() as $component) {
                if ($component instanceof Variable)
                    //$calculator[] = $component;
                    array_push($calculator, $component);

                if ($component instanceof TwoVariableOperation) {
                    if (count($calculator) >= 2) {
                        $result = $component->calculate($calculator[count($calculator) - 2], $calculator[count($calculator) - 1]);
                        $calculator[count($calculator) - 2]->setValue($result);
                        array_pop($calculator);
                    } else
                        throw new CalculationException();
                }

                if ($component instanceof OneVariableOperation) {
                    if (count($calculator) >= 1) {
                        $result = $component->calculate($calculator[count($calculator) - 1]);
                        $calculator[count($calculator) - 1]->setValue($result);
                    } else
                        throw new CalculationException();
                }
            }
        } catch (\ArithmeticError | CalculationException $e) {
            return $e->getMessage();
        }

        return $calculator[0]->getValue();
    }
}