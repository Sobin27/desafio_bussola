<?php

namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Rules;

use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Inputs\MethodCreditCardInput;

class ProcessInstallmentsPaymentCreditCardRule
{
    public function __construct(
        private MethodCreditCardInput $input,
    )
    { }

    public function apply(): array
    {
        $totalValue = 0;
        $totalFees = 1.01;
        foreach ($this->input->items as $item) {
            $itemValue = $item['price'] * $item['quantity'];
            $totalValue += $itemValue;
        }
        $amount = $totalValue * $totalFees ** $this->input->cardInformation[0]['installments'];
        $amountFormated = number_format($amount, 2, '.', '');
        $valuePerInstallment = $amountFormated / $this->input->cardInformation[0]['installments'];
        $valuePerInstallmentFormated = number_format($valuePerInstallment, 2, '.', '');
        return [
            'totalToPay' => $amountFormated,
            'installments' => [
                'amount' => $valuePerInstallmentFormated,
                'total' => $this->input->cardInformation[0]['installments'],
            ],
        ];
    }
}
