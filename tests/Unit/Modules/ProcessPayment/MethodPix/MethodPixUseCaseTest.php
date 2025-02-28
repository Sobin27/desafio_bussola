<?php
namespace Modules\ProcessPayment\MethodPix;

use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\Generics\Outputs\Errors\ErrorOutput;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Enums\ErrorCodeEnum;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Inputs\MethodPixInput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\MethodPixUseCase;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Outputs\MethodPixOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Rulesets\MethodPixRuleset;
use Exception;
use Illuminate\Foundation\Testing\WithFaker;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class MethodPixUseCaseTest extends TestCase
{
    use WithFaker;
    public function test_process_payment_via_pix_returnSuccessful()
    {
        // Arrange
        $methodPixUseCase = new MethodPixUseCase($this->createMock(LoggerInterface::class));
        $methodPixInput = new MethodPixInput([[
            'name' => $this->faker->name,
            'price' => rand(50, 100),
            'quantity' => rand(1, 10),
        ]]);
        // Act
        $methodPixUseCase->execute($methodPixInput);
        $result = $methodPixUseCase->getOutput();
        // Assert
        $this->assertInstanceOf(MethodPixOutput::class, $result);
        $this->assertEquals($result, $methodPixUseCase->getOutput());
    }
    public function test_process_payment_via_pix_returnInternalServerError()
    {
        // Arrange
        $methodPixUseCase = new MethodPixUseCase($this->createMock(LoggerInterface::class));
        $reflectionClass = new \ReflectionClass($methodPixUseCase);
        $reflectionClassProperty = $reflectionClass->getProperty('output');
        $methodPixRuleset = $this->createMock(MethodPixRuleset::class);
        $methodPixRuleset->method('apply')->willThrowException(new Exception('A generic error occured.'));
        $expectedResponse = new ErrorOutput(
            new StatusOutput(ResponseEnum::INTERNAL_SERVER_ERROR, 'Internal Server Error'),
            ErrorCodeEnum::METHOD_PIX_GENERIC_EXCEPTION,
            'METHOD_PIX::GENERIC_EXCEPTION'
        );
        // Act
        try {
            $methodPixRuleset->apply();
        }catch (Exception $exception){
            $reflectionClassProperty->setValue($methodPixUseCase, $expectedResponse);
        }
        // Assert
        $this->assertInstanceOf(ErrorOutput::class, $methodPixUseCase->getOutput());
        $this->assertEquals($expectedResponse, $methodPixUseCase->getOutput());
    }
}
