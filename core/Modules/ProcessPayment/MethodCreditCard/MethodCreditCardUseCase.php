<?php

namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard;

use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\Generics\Outputs\Errors\ErrorOutput;
use App\desafio_bussola\Modules\Generics\Outputs\Interfaces\OutPutInterface;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Enums\ErrorCodeEnum;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Inputs\MethodCreditCardInput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rules\ProcessInstallmentsPaymentCreditCardRule;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rules\ProcessSinglePaymentCreditCardRule;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rulesets\ProcessInstallmentsPaymentCreditCardRuleset;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rulesets\ProcessSinglePaymentCreditCardRulesets;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Exceptions\ProcessMethodPixPaymentDatabaseException;
use Exception;
use Psr\Log\LoggerInterface;

final class MethodCreditCardUseCase
{
    private OutPutInterface $output;

    public function __construct(
        private LoggerInterface $logger,
    )
    { }

    public function execute(MethodCreditCardInput $input): void
    {
        try {
            $this->logger->info('[ProcessPayment::MethodCreditCard] Init use case.');
            $this->output = match ($input->cardInformation[0]['installments']) {
                1 => (new ProcessSinglePaymentCreditCardRulesets(
                    new ProcessSinglePaymentCreditCardRule($input)
                ))->apply(),
                default => (new ProcessInstallmentsPaymentCreditCardRuleset(
                    new ProcessInstallmentsPaymentCreditCardRule($input)
                ))->apply(),
            };
            $this->logger->info('[ProcessPayment::MethodCreditCard] Finish use case.');
        }catch (ProcessMethodPixPaymentDatabaseException $exception){
            $this->output = new ErrorOutput(
                new StatusOutput(ResponseEnum::INTERNAL_SERVER_ERROR, 'Internal Server Error'),
                ErrorCodeEnum::METHOD_CREDIT_CARD_DATABASE_EXCEPTION,
                'METHOD_PIX::PIX_DATABASE_EXCEPTION'
            );
            $this->logger->error(
                '[ProcessPayment::MethodCreditCard] ' . ErrorCodeEnum::METHOD_CREDIT_CARD_DATABASE_EXCEPTION,
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
                ErrorCodeEnum::METHOD_CREDIT_CARD_GENERIC_EXCEPTION,
                'METHOD_PIX::GENERIC_EXCEPTION'
            );
            $this->logger->error(
                '[ProcessPayment::MethodCreditCard] ' . ErrorCodeEnum::METHOD_CREDIT_CARD_GENERIC_EXCEPTION,
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
