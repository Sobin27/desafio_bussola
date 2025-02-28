<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rules;

use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Inputs\MethodCreditCardInput;

class ProcessSinglePaymentCreditCardRule
{
    public function __construct(
        private MethodCreditCardInput $input,
    )
    { }

    public function apply(): string
    {
        $totalValue = 0;
        foreach ($this->input->items as $item) {
            $itemValue = $item['price'] * $item['quantity'];
            $totalValue += $itemValue;
        }
        $discountAmount = $totalValue * 0.1;
        return 'Total to pay '. $totalValue - $discountAmount;
    }
}
