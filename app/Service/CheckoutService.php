<?php
namespace App\Service;

use App\Http\Requests\ProcessPaymentRequest;
use App\Support\Enum\PaymentMethods;

class CheckoutService implements ICheckoutService
{
    private ProcessPaymentRequest $request;

    public function processPayment(ProcessPaymentRequest $request): array
    {
        $this->setRequest($request);
        return match (strtolower($this->request->paymentmethod)) {
            PaymentMethods::PIX => $this->processPix(),
            PaymentMethods::CREDIT_CARD => $this->processCreditCard(),
            default => ['message' => 'Invalid payment method'],
        };
    }
    private function setRequest(ProcessPaymentRequest $request): void
    {
        $this->request = $request;
    }
    private function processPix(): array
    {
        $totalValue = 0;
        foreach ($this->request->items as $item) {
            $itemValue = $item['price'] * $item['quantity'];
            $totalValue += $itemValue;
        }
        $discountAmount = $totalValue * 0.1;
         return [
            'message' => 'Payment processed successfully',
            'totalToPay' => $totalValue - $discountAmount,
        ];
    }
    private function processCreditCard(): array
    {
        if ($this->request->cardInformation[0]['installments'] == 1) {
            return $this->processSinglePaymentCreditCard();
        }
        return $this->processInstallmentsPaymentCreditCard();
    }
    private function processSinglePaymentCreditCard(): array
    {
        $totalValue = 0;
        foreach ($this->request->items as $item) {
            $itemValue = $item['price'] * $item['quantity'];
            $totalValue += $itemValue;
        }
        $discountAmount = $totalValue * 0.1;
        return [
            'message' => 'Payment processed successfully',
            'totalToPay' => $totalValue - $discountAmount,
        ];
    }
    private function processInstallmentsPaymentCreditCard(): array
    {
        $totalValue = 0;
        $totalFees = 1.01;
        foreach ($this->request->items as $item) {
            $itemValue = $item['price'] * $item['quantity'];
            $totalValue += $itemValue;
        }
        $amount = $totalValue * $totalFees ** $this->request->cardInformation[0]['installments'];
        $amountFormated = number_format($amount, 2, '.', '');
        $valuePerInstallment = $amountFormated / $this->request->cardInformation[0]['installments'];
        $valuePerInstallmentFormated = number_format($valuePerInstallment, 2, '.', '');
        return [
            'message' => 'Payment processed successfully',
            'totalToPay' => $amountFormated,
            'installments' => [
                'amount' => $valuePerInstallmentFormated,
                'total' => $this->request->cardInformation[0]['installments'],
            ],
        ];
    }

}
