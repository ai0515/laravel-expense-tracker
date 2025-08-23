<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

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

        $this->call([
            // マスタデータ（カテゴリー、支払い方法）
            PaymentMethodSeeder::class,
            CategorySeeder::class,

            // サンプル収支データの登録
            SampleDataSeeder::class,
        ]);
    }
}
