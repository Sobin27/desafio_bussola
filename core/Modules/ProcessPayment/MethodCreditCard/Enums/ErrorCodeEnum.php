<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Enums;

enum ErrorCodeEnum
{
    const METHOD_CREDIT_CARD_GENERIC_EXCEPTION = 'A generic error occured.';
    const METHOD_CREDIT_CARD_DATABASE_EXCEPTION = 'A error occurred when trying to process the payment with PIX.';
}
