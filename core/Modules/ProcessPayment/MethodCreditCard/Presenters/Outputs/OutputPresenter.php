<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Presenters\Outputs;

use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Outputs\MethodCreditCardOutput;

class OutputPresenter
{
    public array $presenter;

    public function __construct(
        private MethodCreditCardOutput $output
    )
    { }

    public function present(): OutputPresenter
    {
        $this->presenter = [
            'status' => [
                'code' => $this->output->getStatus()->getCode(),
                'message' => $this->output->getStatus()->getMessage(),
            ],
            'processed' => $this->output->getProcessed()
        ];
        return $this;
    }
    public function toArray(): array
    {
        return $this->presenter;
    }
}
