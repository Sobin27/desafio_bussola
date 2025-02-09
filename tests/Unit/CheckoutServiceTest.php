<?php

use App\Http\Requests\ProcessPaymentRequest;
use App\Service\ICheckoutService;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    private ProcessPaymentRequest $request;

    public function test_process_payment_via_pix(): void
    {
        $checkoutService = $this->app->make(ICheckoutService::class);
        $request = mock(ProcessPaymentRequest::class);
        $request->paymentmethod = 'pix';
        $request->items = [
            ['price' => 100, 'quantity' => 2],
        ];
        $request->cardInformation = [];
        $response = $checkoutService->processPayment($request);
        $this->assertEquals('Payment processed successfully', $response['message']);
        $this->assertEquals(180, $response['totalToPay']);
    }
    public function test_process_single_payment_via_credit_card()
    {
        $checkoutService = $this->app->make(ICheckoutService::class);
        $request = mock(ProcessPaymentRequest::class);
        $request->paymentmethod = 'credit_card';
        $request->items = [
            ['price' => 100, 'quantity' => 2],
        ];
        $request->cardInformation = [
            [
                'cardNumber' => '1234 5678 9012 3456',
                'cardHolder' => 'Fulano de Tal',
                'expirationDate' => '12/25',
                'cvv' => '123',
                'installments' => 1,
            ],
        ];
        $response = $checkoutService->processPayment($request);
        $this->assertEquals('Payment processed successfully', $response['message']);
        $this->assertEquals(180, $response['totalToPay']);
    }
    public function test_process_installments_payment_via_credit_card()
    {
        $checkoutService = $this->app->make(ICheckoutService::class);
        $request = mock(ProcessPaymentRequest::class);
        $request->paymentmethod = 'credit_card';
        $request->items = [
            ['price' => 100, 'quantity' => 2],
        ];
        $request->cardInformation = [
            [
                'cardNumber' => '1234 5678 9012 3456',
                'cardHolder' => 'Fulano de Tal',
                'expirationDate' => '12/25',
                'cvv' => '123',
                'installments' => 2,
            ],
        ];
        $response = $checkoutService->processPayment($request);
        $this->assertEquals('Payment processed successfully', $response['message']);
        $this->assertEquals(204.02, $response['totalToPay']);
    }
}
