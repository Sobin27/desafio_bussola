<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Enums;

enum ErrorCodeEnum
{
    const METHOD_PIX_GENERIC_EXCEPTION = 'A generic error occured.';
    const METHOD_PIX_DATABASE_EXCEPTION = 'A error occurred when trying to process the payment with PIX.';
}
