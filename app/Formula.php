<?php

namespace App;

use App\Interfaces\FormulaComponent;
use App\Operations\VariableOperation;

class Formula
{
    /**
     * @var string
     */
    protected $infix;

    /**
     * Output postfix (polish reversed) formula
     *
     * @var FormulaComponent[]
     */
    protected $postfix = [];

    /**
     * Formula constructor.
     *
     * @param string $stringExpression
     */

    /**
     * @var string
     */
    protected $errorMessage = null;

    public function __construct(string $input)
    {
        $input = str_replace(" ", "", $input);
        $input = str_replace(',', '.', $input);
        $this->infix = $input;
        $converter = new RpnConverter($this);
    }

    /**
     * @return string
     */
    public function getInfix()
    {
        return $this->infix;
    }

    /**
     * @return FormulaComponent[]
     */
    public function getPostfix()
    {
        return $this->postfix;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $postfix = "";
        foreach ($this->postfix as $component)
            $postfix .= $component->getSymbol();
        return $postfix;
    }

    /**
     * @return Variable[]
     */
    public function getVariables()
    {
        $variables = array_filter($this->postfix, function ($component) {
            return $component instanceof Variable ? 1 : 0;
        });
        return $variables;
    }

    /**
     * @return string[]
     */
    public function getVariablesNames()
    {
        $variables = $this->getVariables();
        $symbols = [];
        foreach ($variables as $variable)
            array_push($symbols, $variable->getSymbol());
        return $symbols;
    }

    /**
     * @return float|string
     */
    public function calculate()
    {
        $calculator = new Calculator($this);
        return $calculator->calculate();
    }

    /**
     * Looking for a variable/-s in the formula by symbol
     *
     * @param string $symbol
     * @return Variable | Variable[]
     */
    public function findVariableByName($symbol)
    {
        $variables = array_filter($this->postfix, function ($variable) use ($symbol) {
            return $variable->getSymbol() == $symbol;
        });

        return count($variables) == 1 ? array_shift($variables) : $variables;
    }

    /**
     * Sets value for a variable or array of variables with the same symbol
     *
     * @param array|Variable $variables
     * @param float|int $value
     */
    public function setVariableValue($variables, $value)
    {
        if ($variables instanceof \ErrorException)
            return;

        if ($variables instanceof Variable)
            $variables->setValue($value);
        else
            array_walk($variables, function ($var) use ($value) {
                $var->setValue($value);
            });
    }

    /**
     * Checks if all variables in expression have numerical values
     * @return bool
     */
    protected function eachVariableHasCorrectValue()
    {
        foreach ($this->postfix as $variable) {
            if (($variable instanceof Variable) && ($variable->getValue() === null || !is_numeric($variable->getValue())))
                return false;
        }
        return true;
    }

    /**
     * A function to manipulate postfix by RpnConverter
     * @see RpnConverter
     * @param FormulaComponent|FormulaComponent[] $component
     */
    public function pushToPostfix($component)
    {
        $component instanceof FormulaComponent
            ? array_push($this->postfix, $component)
            : $this->postfix = array_merge($this->postfix, $component);
    }

    /**
     * @param string
     * @return void
     */
    public function setErrorMessage(string $message)
    {
        $this->errorMessage = $message;
    }

    /**
     * Checks if postfix contains only Variable and VariableOperation
     *
     * to be reconsidered
     * @return bool
     */
    public function isFormulaValid()
    {
        return !$this->errorMessage ? true : false;
    }


    /*public function isExpressionValid()
    {
        $notVariables = array_udiff($this->postfix, $this->variables, function ($component, $variable) {
            return $component->getSymbol() == $variable->getSymbol() ? 1 : 0;
        });
        dd($notVariables);
        $oneCounter = 0;
        $twoCounter = 0;
        foreach ($notVariables as $notVariable) {
            if ($notVariable instanceof OneVariableOperation)
                $oneCounter++;
            elseif ($notVariable instanceof TwoVariableOperation)
                $twoCounter++;
            else
                return false;
        }
        return $twoCounter < count($this->variables) ? true : false;

    }*/
}
