<?php

namespace App;

use App\Interfaces\FormulaComponent;
use App\Operations\VariableOperation;
use App\Operations\Auxiliary\LeftBracket;
use App\Operations\Auxiliary\RightBracket;
use App\Exceptions\InvalidFormulaException;

/**
 * Class RpnConverter
 *
 * @package App
 */
class RpnConverter
{
    protected $input;
    protected $output;

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
     * @param string
     */
    public function __construct(string $input)
    {
        $this->input = preg_split(
            self::OPERATION_PATTERN,
            $input,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );
    }

    /**
     * Main converting method in RpnConverter
     *
     * @throws InvalidFormulaException
     */
    public function convert()
    {
        try {
            // Unary minus is possible at the beginning of formula and after the left bracket
            $unaryMinusPossibility = true;

            foreach ($this->input as $component) {
                $component = ComponentFactory::createNewComponent($component, $unaryMinusPossibility);
                $unaryMinusPossibility = false;

                if ($component instanceof Variable) {
                    $this->output[] = $component;
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

            if ($this->stackContainsOnlyOperations()) {
                $this->output = array_merge($this->output, $this->stack);
                return $this->output;
            } else
                throw new InvalidFormulaException("There are excessive left brackets in the formula");

        } catch (InvalidFormulaException $e) {
            return $e->getMessage();
        }

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
                    $this->output[] = $prevOperation;
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
                array_push($this->output, $prevOperation);
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