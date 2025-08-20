<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 収支カテゴリーデータを登録する
        $data = [
            ['category' => '食費'],
            ['category' => '消耗品'],
            ['category' => '光熱費'],
            ['category' => '固定費'],
            ['category' => '経費'],
            ['category' => '給料'],
        ];

        foreach ($data as $category) {
            Category::create($category);
        }
    }
}
