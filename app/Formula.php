<?php

namespace App;

use App\Interfaces\FormulaComponent;
use App\Operations\VariableOperation;
use phpDocumentor\Reflection\Types\Array_;

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
    }

    public function convert()
    {
        $converter = new RpnConverter($this->infix);
        $result = $converter->convert();
        is_string($result) ? $this->errorMessage = $result : $this->postfix = $result;
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
    public function getError()
    {
        return $this->errorMessage;
    }

    /**
     * @return string
     * For dev
     * Planned to be replaced with the function below,
     * as there seems to be no much sense in postfix string
     */

    public function __toString()
    {
        $postfix = "";
        foreach ($this->postfix as $component)
            $postfix .= $component->getSymbol();
        return $postfix;
    }

    /*public function __toString() //
    {
        return $this->isFormulaValid() ? $this->infix : $this->errorMessage;
    }*/

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
    public function findVariableByName(string $symbol)
    {
        $variables = array_filter($this->postfix, function ($variable) use ($symbol) {
            return $variable->getSymbol() == $symbol;
        });

        return count($variables) == 1 ? array_shift($variables) : $variables;
    }

    /**
     * Sets value for a variable or array of variables with the same symbol
     *
     * @param array|Variable $variable
     * @param float $value
     */
    public function setVariableValue($variable, float $value)
    {
        if (is_array($variable))
            array_walk($variable, function ($var) use ($value) {
                $var->setValue($value);
            });
        else
            $variable->setValue($value);
    }

    /**
     * @param array
     * @return void
     */
    public function setValues(array $variables)
    {
        foreach ($variables as $symbol => $value){
            $this->setVariableValue($this->findVariableByName($symbol), $value);
        }
    }

    /**
     * @param string
     * @return void
     */
    public function setErrorMessage(string $msg)
    {
        $this->errorMessage = $msg;
    }

    /**
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
