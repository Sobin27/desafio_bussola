<?php
namespace App\desafio_bussola\Modules\ProcessPayment\MethodPix\Exceptions;

use App\desafio_bussola\Modules\Generics\Collections\HasDataCollection;

class ProcessMethodPixPaymentDatabaseException extends \Exception
{
    use HasDataCollection;
    public function __construct(\Throwable $previous = null, string $message = '', int $code = 0)
    {
        parent::__construct($message, $code, $previous);
    }
}
