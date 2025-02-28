<?php
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    public function test_checkout_payment_via_pix()
    {
        $request = [
            'paymentMethod' => 'pix',
            'items' => [
                [
                    'name' => 'Product 1',
                    'price' => 50,
                    'quantity' => 10,
                ]
            ]
        ];
        $response = $this->postJson('/api/checkout', $request);
        $response->assertStatus(200)
            ->assertJson([
                'presenter' => [
                    'status' => [
                        'code' => 200,
                        'message' => 'Payment Processed Successfully',
                    ],
                    'processed' => 'Total to pay '. 450,
                ]
            ]);
    }
    public function test_checkout_single_payment_via_credit_card()
    {
        $request = [
            'paymentMethod' => 'credit_card',
            'items' => [
                [
                    'name' => 'Product 1',
                    'price' => 50,
                    'quantity' => 10,
                ]
            ],
            'cardInformation' => [
                [
                    'cardNumber' => '1234567890123456',
                    'cardHolder' => 'John Doe',
                    'expirationDate' => '12/2022',
                    'cvv' => '123',
                    'installments' => 1,
                ]
            ]
        ];
        $response = $this->postJson('/api/checkout', $request);
        $response->assertStatus(200)
            ->assertJson([
                'presenter' => [
                    'status' => [
                        'code' => 200,
                        'message' => 'Payment Processed Successfully',
                    ],
                    'processed' => 'Total to pay '. 450,
                ]
            ]);
    }
    public function test_checkout_installments_payment_via_credit_card()
    {
        $request = [
            'paymentMethod' => 'credit_card',
            'items' => [
                [
                    'name' => 'Product 1',
                    'price' => 50,
                    'quantity' => 10,
                ]
            ],
            'cardInformation' => [
                [
                    'cardNumber' => '1234567890123456',
                    'cardHolder' => 'John Doe',
                    'expirationDate' => '12/2022',
                    'cvv' => '123',
                    'installments' => 12,
                ]
            ]
        ];
        $response = $this->postJson('/api/checkout', $request);
        $response->assertStatus(200)
            ->assertJson([
                'presenter' => [
                    'status' => [
                        'code' => 200,
                        'message' => 'Payment Processed Successfully',
                    ],
                    'processed' => [
                        'totalToPay' => 563.41,
                        'installments' => [
                            'amount' => 46.95,
                            'total' => 12,
                        ]
                    ]
                ]
            ]);
    }
}
