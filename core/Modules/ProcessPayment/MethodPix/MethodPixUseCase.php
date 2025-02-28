<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix;

use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\Generics\Outputs\Errors\ErrorOutput;
use App\desafio_bussola\Modules\Generics\Outputs\Interfaces\OutPutInterface;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Enums\ErrorCodeEnum;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Exceptions\ProcessMethodPixPaymentDatabaseException;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Inputs\MethodPixInput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Rules\MethodPixRule;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Rulesets\MethodPixRuleset;
use Exception;
use Psr\Log\LoggerInterface;


final class MethodPixUseCase
{
    private OutPutInterface $output;

    public function __construct(
        private LoggerInterface $logger,
    )
    { }

    public function execute(MethodPixInput $input): void
    {
        try {
            $this->logger->info('[ProcessPayment::MethodPix] Init use case.');
            $this->output = (new MethodPixRuleset(
                new MethodPixRule($input)
            ))->apply();
            $this->logger->info('[ProcessPayment::MethodPix] Finish use case.');
        }catch (ProcessMethodPixPaymentDatabaseException $exception){
            $this->output = new ErrorOutput(
                new StatusOutput(ResponseEnum::INTERNAL_SERVER_ERROR, 'Internal Server Error'),
                ErrorCodeEnum::METHOD_PIX_DATABASE_EXCEPTION,
                'METHOD_PIX::PIX_DATABASE_EXCEPTION'
            );
            $this->logger->error(
                '[ProcessPayment::MethodPix] ' . ErrorCodeEnum::METHOD_PIX_DATABASE_EXCEPTION,
                [
                    "exception" => get_class($exception),
                    "message" => $exception->getMessage(),
                    "previous" => [
                        "exception" => $exception->getPrevious() ? get_class($exception->getPrevious()) : null,
                        "message" => $exception->getPrevious() ? $exception->getPrevious()->getMessage() : null,
                    ],
                    "trace" => $exception->getTrace(),
                    'data' => []
                ]
            );
        } catch (Exception $exception){
            $this->output = new ErrorOutput(
                new StatusOutput(ResponseEnum::INTERNAL_SERVER_ERROR, 'Internal Server Error'),
                ErrorCodeEnum::METHOD_PIX_GENERIC_EXCEPTION,
                'METHOD_PIX::GENERIC_EXCEPTION'
            );
            $this->logger->error(
                '[ProcessPayment::MethodPix] ' . ErrorCodeEnum::METHOD_PIX_GENERIC_EXCEPTION,
                [
                    "exception" => get_class($exception),
                    "message" => $exception->getMessage(),
                    "previous" => [
                        "exception" => $exception->getPrevious() ? get_class($exception->getPrevious()) : null,
                        "message" => $exception->getPrevious() ? $exception->getPrevious()->getMessage() : null,
                    ],
                    "trace" => $exception->getTrace(),
                    'data' => []
                ]
            );
        }
    }
    public function getOutput(): OutPutInterface
    {
        return $this->output;
    }
}
