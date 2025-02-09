<?php
namespace App\Service;

use App\Http\Requests\ProcessPaymentRequest;

interface ICheckoutService
{
    public function processPayment(ProcessPaymentRequest $request): array;
}
