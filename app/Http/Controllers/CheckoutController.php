<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProcessPaymentRequest;
use App\Service\ICheckoutService;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function __construct(
        private ICheckoutService $checkoutService,
    )
    { }
    public function processPayment(ProcessPaymentRequest $request): Response
    {
        try {
            return response()->json($this->checkoutService->processPayment($request));
        }catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
