<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Presenters\Outputs;

use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Outputs\MethodPixOutput;

class OutputPresenter
{
    public array $presenter;

    public function __construct(
        private MethodPixOutput $output
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
