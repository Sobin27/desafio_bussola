<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string paymentmethod
 * @property array items
 * @property array cardInformation
 */

class ProcessPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'paymentMethod' => 'required|string',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'cardInformation' => 'nullable|array',
            'cardInformation.*.cardNumber' => 'required|string',
            'cardInformation.*.cardHolder' => 'required|string',
            'cardInformation.*.expirationDate' => 'required|string',
            'cardInformation.*.cvv' => 'required|string',
            'cardInformation.*.installments' => 'required|integer',
        ];
    }
}
