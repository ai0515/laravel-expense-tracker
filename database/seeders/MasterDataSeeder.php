<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            // マスタデータ（カテゴリー、支払い方法）
            PaymentMethodSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
