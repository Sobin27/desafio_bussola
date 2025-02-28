<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rulesets;

use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Outputs\MethodCreditCardOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rules\ProcessInstallmentsPaymentCreditCardRule;


class ProcessInstallmentsPaymentCreditCardRuleset
{
    public function __construct(
        private ProcessInstallmentsPaymentCreditCardRule $processInstallmentsPaymentCreditCardRule,
    )
    { }

    public function apply(): MethodCreditCardOutput
    {
        return new MethodCreditCardOutput(
            new StatusOutput(ResponseEnum::OK, 'Payment Processed Successfully'),
            $this->processInstallmentsPaymentCreditCardRule->apply()
        );
    }
}
