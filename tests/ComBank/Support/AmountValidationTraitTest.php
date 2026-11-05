<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 10/24/26
 * Time: 2:35 PM
 */

use ComBank\Support\Traits\AmountValidationTrait;
use PHPUnit\Framework\TestCase;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;

/**
 * Concrete class to test the trait
 */
class ConcreteAmountValidator
{
    use AmountValidationTrait;
}

class AmountValidationTraitTest extends TestCase
{

    /**
     * @test
     */
    public function testValidateAmountWithValidPositiveAmount()
    {
        $validator = new ConcreteAmountValidator();
        // Should not throw any exception
        $this->expectNotToPerformAssertions();
        $validator->validateAmount(100.50);
    }

    /**
     * @test
     */
    public function testValidateAmountWithZeroThrowsException()
    {
        $validator = new ConcreteAmountValidator();
        $this->expectException(ZeroAmountException::class);
        $validator->validateAmount(0);
    }

    /**
     * @test
     */
    public function testValidateAmountWithNegativeAmountThrowsException()
    {
        $validator = new ConcreteAmountValidator();
        $this->expectException(ZeroAmountException::class);
        $validator->validateAmount(-50.25);
    }

    /**
     * @test
     * @dataProvider invalidAmountProvider
     */
    public function testValidateAmountWithNonPositiveAmountThrowsException($amount)
    {
        $validator = new ConcreteAmountValidator();
        $this->expectException(ZeroAmountException::class);
        $validator->validateAmount($amount);
    }

    /**
     * @return array
     */
    public function invalidAmountProvider()
    {
        return [
            [0],                           // Zero amount
            [-25.50],                      // Negative amount
            [-0.01],                       // Small negative amount
        ];
    }
}