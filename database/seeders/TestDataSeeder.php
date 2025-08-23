<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\Category;
use App\Models\Transaction;
use App\Enums\TransactionType;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user = User::first();

        //出金データの登録
        $paymentMethod = PaymentMethod::first();
        $categories = Category::limit(2)->get();

        $transaction = Transaction::factory()
            ->for($user, 'user')
            ->for($paymentMethod, 'paymentMethod')
            ->state(['amount' => 1000])
            ->state(['note' => 'コンビニ'])
            ->state(['transaction_type' => TransactionType::PAYMENT])
            ->create();
        $transaction->categories()->attach($categories->pluck('id'));

        //入金データの登録
        $paymentMethod = PaymentMethod::where('payment_method', '銀行口座')->first();
        $category = Category::where('category', '給料')->first();
        
        $transaction = Transaction::factory()
            ->for($user, 'user')
            ->for($paymentMethod, 'paymentMethod')
            ->state(['amount' => 20000])
            ->state(['note' => 'アルバイト'])
            ->state(['transaction_type' => TransactionType::INCOME])
            ->create();
        $transaction->categories()->attach($category->id);
    }
}
