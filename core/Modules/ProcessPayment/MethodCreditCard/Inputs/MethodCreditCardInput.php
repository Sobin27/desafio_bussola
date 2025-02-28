<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Inputs;

class MethodCreditCardInput
{
    public function __construct(
        public array $items,
        public array $cardInformation
    )
    { }
}
