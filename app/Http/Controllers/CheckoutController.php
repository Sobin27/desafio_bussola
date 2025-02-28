<?php
namespace App\Http\Controllers;

use App\desafio_bussola\Modules\Generics\Enums\PaymentMethods;
use App\desafio_bussola\Modules\Generics\Enums\ResponseEnum;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\Inputs\MethodCreditCardInput;
use App\desafio_bussola\Modules\ProcessPayment\MethodCreditCard\MethodCreditCardUseCase;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\Inputs\MethodPixInput;
use App\desafio_bussola\Modules\ProcessPayment\MethodPix\MethodPixUseCase;
use App\Http\Requests\ProcessPaymentRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function __construct(
        private LoggerInterface $logger,
    )
    { }

    public function processPayment(ProcessPaymentRequest $request): Response
    {
        switch ($request['paymentMethod']){
            case PaymentMethods::PIX:
                $pixUseCase = new MethodPixUseCase($this->logger);
                $pixUseCase->execute(new MethodPixInput($request['items']));
                return response()->json($pixUseCase->getOutput()->getPresenter()->toArray());
            case PaymentMethods::CREDIT_CARD:
                $creditCardUseCase = new MethodCreditCardUseCase($this->logger);
                $creditCardUseCase->execute(new MethodCreditCardInput($request['items'], $request['cardInformation']));
                return response()->json($creditCardUseCase->getOutput()->getPresenter());
            default:
                return response()->json(['message' => 'Invalid payment method'], ResponseEnum::BAD_REQUEST);
        }
    }
}
