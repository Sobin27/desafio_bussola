<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Outputs;

use App\desafio_bussola\Modules\Generics\Outputs\Interfaces\OutPutInterface;
use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Presenters\Outputs\OutputPresenter;

class MethodPixOutput implements OutPutInterface
{
    public function __construct(
        public StatusOutput $status,
        private string $processed
    )
    { }

    public function getStatus(): StatusOutput
    {
        return $this->status;
    }

    public function getProcessed(): string
    {
        return $this->processed;
    }

    public function getPresenter(): OutputPresenter
    {
        return (new OutputPresenter($this))->present();
    }
}
