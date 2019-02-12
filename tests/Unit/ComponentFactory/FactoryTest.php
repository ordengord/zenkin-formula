<?php

namespace Tests\Unit\ComponentFactory;

use PHPUnit\Framework\TestCase;
use App\ComponentFactory;
use App\Constant;
use App\Operations\Trigonometric\Arccotangent;
use App\Variable;

class FactoryTest extends TestCase
{
    /**
     * @test
     */
    public function operations_and_variables_can_be_set()
    {
        $arcctg = ComponentFactory::createNewComponent('arcctg');
        $var = ComponentFactory::createNewComponent('Ab4F');
        $constant = ComponentFactory::createNewComponent('23.5');
        $this->assertInstanceOf(Arccotangent::class, $arcctg);
        $this->assertInstanceOf(Variable::class, $var);
        $this->assertInstanceOf(Constant::class, $constant);
        $this->assertNotNull($constant->getValue());
    }

}