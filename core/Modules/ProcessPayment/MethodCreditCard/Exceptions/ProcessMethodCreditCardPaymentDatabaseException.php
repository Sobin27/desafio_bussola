<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Exceptions;

use App\desafio_bussola\Modules\Generics\Collections\HasDataCollection;

class ProcessMethodCreditCardPaymentDatabaseException extends \Exception
{
    use HasDataCollection;
    public function __construct(\Throwable $previous = null, string $message = '', int $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
