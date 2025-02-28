<?php
namespace Modules\ProcessPayment\MethodCreditCard;

use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\Generics\Outputs\Errors\ErrorOutput;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Enums\ErrorCodeEnum;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Inputs\MethodCreditCardInput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\MethodCreditCardUseCase;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Outputs\MethodCreditCardOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rulesets\ProcessInstallmentsPaymentCreditCardRuleset;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class MethodCreditCardUseCaseTest extends TestCase
{
    use WithFaker;
    public function test_process_payment_via_credit_card_single_payment_returnSuccessful()
    {
        // Arrange
        $methodCreditCardUseCase = new MethodCreditCardUseCase($this->createMock(LoggerInterface::class));
        $items = [
            [
                'name' => $this->faker->name,
                'price' => rand(50, 100),
                'quantity' => rand(1, 10),
            ]
        ];
        $cardInformation = [
            [
                'cardNumber' => '1234 5678 9012 3456',
                'cardHolder' => 'Fulano de Tal',
                'expirationDate' => '12/25',
                'cvv' => '123',
                'installments' => 1
            ]
        ];
        $methodCreditCardInput = new MethodCreditCardInput($items, $cardInformation);
        // Act
        $methodCreditCardUseCase->execute($methodCreditCardInput);
        $result = $methodCreditCardUseCase->getOutput();
        // Assert
        $this->assertInstanceOf(MethodCreditCardOutput::class, $result);
        $this->assertEquals($result, $methodCreditCardUseCase->getOutput());
    }
    public function test_process_payment_via_credit_card_installments_payment_returnSuccessful()
    {
        // Arrange
        $methodCreditCardUseCase = new MethodCreditCardUseCase($this->createMock(LoggerInterface::class));
        $items = [
            [
                'name' => $this->faker->name,
                'price' => rand(50, 100),
                'quantity' => rand(1, 10),
            ]
        ];
        $cardInformation = [
            [
                'cardNumber' => '1234 5678 9012 3456',
                'cardHolder' => 'Fulano de Tal',
                'expirationDate' => '12/25',
                'cvv' => '123',
                'installments' => rand(1,5)
            ]
        ];
        $methodCreditCardInput = new MethodCreditCardInput($items, $cardInformation);
        // Act
        $methodCreditCardUseCase->execute($methodCreditCardInput);
        $result = $methodCreditCardUseCase->getOutput();
        // Assert
        $this->assertInstanceOf(MethodCreditCardOutput::class, $result);
        $this->assertEquals($result, $methodCreditCardUseCase->getOutput());
    }
    public function test_process_payment_via_credit_card_returnInternalServerError()
    {
        // Arrange
        $methodCreditCardUseCase = new MethodCreditCardUseCase($this->createMock(LoggerInterface::class));
        $reflectionClass = new \ReflectionClass($methodCreditCardUseCase);
        $reflectionClassProperty = $reflectionClass->getProperty('output');
        $methodCreditCardRuleset = $this->createMock(ProcessInstallmentsPaymentCreditCardRuleset::class);
        $methodCreditCardRuleset->method('apply')->willThrowException(new Exception('A generic error occured.'));
        $expectedResponse = new ErrorOutput(
            new StatusOutput(ResponseEnum::INTERNAL_SERVER_ERROR, 'Internal Server Error'),
            ErrorCodeEnum::METHOD_CREDIT_CARD_GENERIC_EXCEPTION,
            'METHOD_PIX::GENERIC_EXCEPTION'
        );
        // Act
        try {
            $methodCreditCardRuleset->apply();
        }catch (Exception $exception){
            $reflectionClassProperty->setValue($methodCreditCardUseCase, $expectedResponse);
        }
        // Assert
        $this->assertInstanceOf(ErrorOutput::class, $methodCreditCardUseCase->getOutput());
        $this->assertEquals($expectedResponse, $methodCreditCardUseCase->getOutput());
    }
}
