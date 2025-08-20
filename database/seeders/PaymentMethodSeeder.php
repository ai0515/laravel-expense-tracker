<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 支払い方法データを登録する
        $data = [
            ['payment_method' => '現金'],
            ['payment_method' => 'カード'],
            ['payment_method' => '銀行口座'],
        ];

        foreach ($data as $payment_method) {
            PaymentMethod::create($payment_method);
        }
    }
}
