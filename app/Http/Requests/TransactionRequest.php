<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'amount' => 'integer|required|min:0',
            'transaction_date' => 'required',
            'category_ids' => 'array|required',
            'category_ids.*' => 'exists:categories,id',
            'income' => 'required',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'note' => 'max:100'
        ];
    }

    // エラーメッセージが画面表示される項目のみ、attribute を設定
    public function attributes(): array
    {
        return [
            'amount' => '金額',
            'category' => 'カテゴリー',
            'category_ids' => 'カテゴリー',
            'note' => 'メモ',
        ];
    }
}
