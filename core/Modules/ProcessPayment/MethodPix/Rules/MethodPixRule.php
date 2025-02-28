<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Rules;

use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Inputs\MethodPixInput;

class MethodPixRule
{
    public function __construct(
        public MethodPixInput $input,
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
