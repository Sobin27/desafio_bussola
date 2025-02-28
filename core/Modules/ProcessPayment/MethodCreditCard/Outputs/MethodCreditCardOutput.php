<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Outputs;

use App\desafio_bussola\Modules\Generics\Outputs\Interfaces\OutPutInterface;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Presenters\Outputs\OutputPresenter;

class MethodCreditCardOutput implements OutPutInterface
{
    public function __construct(
        private StatusOutput $status,
        private mixed $processed
    )
    { }

    public function getStatus(): StatusOutput
    {
        return $this->status;
    }

    public function getProcessed(): mixed
    {
        return $this->processed;
    }

    public function getPresenter(): OutputPresenter
    {
        return (new OutputPresenter($this))->present();
    }
}
