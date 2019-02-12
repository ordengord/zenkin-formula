<?php

namespace App;

use App\Interfaces\FormulaComponent;
use App\Operations\VariableOperation;
use App\Operations\Auxiliary\LeftBracket;
use App\Operations\Auxiliary\RightBracket;
use App\Exceptions\InvalidFormulaException;

/**
 * Class PolishConverter
 *
 * @package App
 */
class RpnConverter
{
    /***
     * @var Formula
     */
    protected $formula;

    /**
     *
     * @var FormulaComponent[]
     */
    protected $stack = [];

    /**
     * Contains pattern for splitting the input
     * formula with currently supported operations
     */
    protected const OPERATION_PATTERN = '/([\+\-\*\/\^\(\)]|sqrt|sin|cos|tg|ctg|arctg|arcsin|arccos|arcctg|ln|log|lg|])/';

    /**
     * RpnConverter constructor.
     * @param Formula $formula
     */
    public function __construct(Formula $formula)
    {
        $this->formula = $formula;

        $infix = preg_split(
            self::OPERATION_PATTERN,
            $this->formula->getInfix(),
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );

        try {
            $this->convert($infix);
        } catch (InvalidFormulaException $e) {
            $formula->setErrorMessage($e->getMessage());
        }

    }

    /**
     * Main converting method in RpnConverter
     *
     * Using abstract class ComponentCreator, it creates objects of FormulaComponent in foreach cycle.
     * Then proceeding with calling handlers for every possible subclass of FormulaComponent.
     * When handling, FormulaComponent can be added into $stack or $formula->postfix
     * Variables are added to the $formula->postfix immediately
     * When the cycle is over, $stack is pushed onto the end of $formula->postfix
     *
     * @param String[]
     * @return void
     * @throws InvalidFormulaException
     */
    protected function convert(Array $infix)
    {
        // Unary minus is possible in the beginning of expression and after the left bracket
        $unaryMinusPossibility = true;

        foreach ($infix as $component) {
            $component = ComponentFactory::createNewComponent($component, $unaryMinusPossibility);
            $unaryMinusPossibility = false;

            if ($component instanceof Variable) {
                $this->formula->pushToPostfix($component);
                continue;
            }

            if ($component instanceof LeftBracket) {
                $this->handleLeftBracket($component);
                $unaryMinusPossibility = true;
                continue;
            }

            if ($component instanceof RightBracket) {
                $this->handleRightBracket();
                continue;
            }

            if ($component instanceof VariableOperation) {
                $this->handleOperation($component);
                continue;
            }
        }

        if ($this->stackContainsOnlyOperations())
            $this->formula->pushToPostfix($this->stack);
        else
            throw new InvalidFormulaException("There are excessive left brackets in the formula");
    }

    /**
     * @param VariableOperation $operation
     * @return void
     */
    protected function handleOperation(VariableOperation $operation)
    {
        if (empty($this->stack))
            array_push($this->stack, $operation);
        else {
            $numLeftBrackets = $this->howManyOpenLeftBrackets();
            $operation->increasePriority(10 * $numLeftBrackets);
            foreach ($this->stack as $prevOperation) {
                if ($prevOperation->getPriority() >= $operation->getPriority()) {
                    $this->formula->pushToPostfix($prevOperation);
                    array_shift($this->stack);
                }
            }
            array_unshift($this->stack, $operation);
        }
    }

    /**
     * Handler for left bracket
     *
     * @param LeftBracket $component
     * @return void
     */
    protected function handleLeftBracket($component)
    {
        array_unshift($this->stack, $component);
    }

    /**
     * @return void
     * @throws InvalidFormulaException
     */
    protected function handleRightBracket()
    {
        foreach ($this->stack as $prevOperation) {
            if ($prevOperation instanceof LeftBracket) {
                array_shift($this->stack);
                return;
            } else {
                $this->formula->pushToPostfix($prevOperation);
                array_shift($this->stack);
            }
        }

        throw new InvalidFormulaException("Number of brackets does not match");
    }

    /**
     *
     * @return int
     */
    protected function howManyOpenLeftBrackets()
    {
        $count = 0;
        foreach ($this->stack as $component) {
            if ($component instanceof LeftBracket)
                ++$count;
        }
        return $count;
    }

    /**
     * @return bool
     */
    protected function stackContainsOnlyOperations()
    {
        foreach ($this->stack as $component) {
            if (!$component instanceof VariableOperation)
                return false;
        }
        return true;
    }


}