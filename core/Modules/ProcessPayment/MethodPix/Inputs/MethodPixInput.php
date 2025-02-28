<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Inputs;

class MethodPixInput
{
    public function __construct(
        public array $items,
    )
    { }
}
