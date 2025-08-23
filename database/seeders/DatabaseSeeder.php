<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // マスタデータの登録
        $this->call(MasterDataSeeder::class);

        // テスト用データの登録
        if (app()->environment('local')) {
            $this->call(TestDataSeeder::class);
        } 
    }
}
