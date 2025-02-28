<?php
namespace App\desafio_bussola\Modules\Generics\Outputs\Interfaces;

use App\desafio_bussola\Modules\Generics\Outputs\StatusOutput;

interface OutPutInterface
{
    public function getStatus(): StatusOutput;
    public function getPresenter();
}
