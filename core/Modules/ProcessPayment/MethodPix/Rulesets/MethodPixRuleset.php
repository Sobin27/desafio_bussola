<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Rulesets;

use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Outputs\MethodPixOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Rules\MethodPixRule;

class MethodPixRuleset
{
    public function __construct(
        private MethodPixRule $methodPixRule,
    )
    { }

    public function apply(): MethodPixOutput
    {
        return new MethodPixOutput(
            new StatusOutput(ResponseEnum::OK, 'Payment Processed Successfully'),
            $this->methodPixRule->apply()
        );
    }
}
