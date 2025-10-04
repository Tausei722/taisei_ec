<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ReviewSiteCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 既存カテゴリを削除（外部キー制約を考慮）
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $categories = [
            [
                'name' => 'レストラン・カフェ',
                'description' => 'レストラン、カフェ、居酒屋、バーなど',
                'icon' => '🍽️',
                'is_active' => true,
            ],
            [
                'name' => '美容・健康',
                'description' => '美容院、ネイルサロン、エステ、マッサージなど',
                'icon' => '💄',
                'is_active' => true,
            ],
            [
                'name' => 'ホテル・宿泊',
                'description' => 'ホテル、旅館、民宿、ゲストハウスなど',
                'icon' => '🏨',
                'is_active' => true,
            ],
            [
                'name' => 'ショッピング',
                'description' => 'デパート、専門店、商業施設など',
                'icon' => '🛍️',
                'is_active' => true,
            ],
            [
                'name' => '医療・病院',
                'description' => '病院、クリニック、歯科、薬局など',
                'icon' => '🏥',
                'is_active' => true,
            ],
            [
                'name' => 'エンターテイメント',
                'description' => '映画館、カラオケ、ゲームセンター、テーマパークなど',
                'icon' => '🎭',
                'is_active' => true,
            ],
            [
                'name' => 'スポーツ・フィットネス',
                'description' => 'ジム、ヨガスタジオ、スポーツクラブなど',
                'icon' => '💪',
                'is_active' => true,
            ],
            [
                'name' => '教育・習い事',
                'description' => '学習塾、音楽教室、料理教室、語学スクールなど',
                'icon' => '📚',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}