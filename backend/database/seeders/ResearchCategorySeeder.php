<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class ResearchCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 既存のカテゴリーをクリア
        Category::truncate();

        $categories = [
            [
                'name' => '情報科学・コンピュータ',
                'description' => 'ソフトウェア工学、AI、機械学習、データサイエンス等',
                'icon' => '💻',
                'is_active' => true
            ],
            [
                'name' => '電気・電子工学',
                'description' => '回路設計、信号処理、通信技術、制御工学等',
                'icon' => '⚡',
                'is_active' => true
            ],
            [
                'name' => '機械工学',
                'description' => '機械設計、材料工学、熱力学、流体力学等',
                'icon' => '⚙️',
                'is_active' => true
            ],
            [
                'name' => '化学・材料科学',
                'description' => '有機化学、無機化学、材料科学、ナノテクノロジー等',
                'icon' => '🧪',
                'is_active' => true
            ],
            [
                'name' => '生物学・生命科学',
                'description' => '分子生物学、遺伝学、生化学、細胞生物学等',
                'icon' => '🧬',
                'is_active' => true
            ],
            [
                'name' => '医学・薬学',
                'description' => '基礎医学、臨床医学、薬理学、病理学等',
                'icon' => '🏥',
                'is_active' => true
            ],
            [
                'name' => '土木・建築工学',
                'description' => '構造工学、都市計画、建築設計、環境工学等',
                'icon' => '🏗️',
                'is_active' => true
            ],
            [
                'name' => '数学・統計学',
                'description' => '応用数学、統計学、数理モデリング、最適化等',
                'icon' => '📐',
                'is_active' => true
            ],
            [
                'name' => '物理学',
                'description' => '理論物理、実験物理、量子力学、相対性理論等',
                'icon' => '🔬',
                'is_active' => true
            ],
            [
                'name' => '地球・環境科学',
                'description' => '地質学、気象学、海洋学、環境科学等',
                'icon' => '🌍',
                'is_active' => true
            ],
            [
                'name' => '経済学・経営学',
                'description' => 'マクロ経済学、ミクロ経済学、経営戦略、マーケティング等',
                'icon' => '📊',
                'is_active' => true
            ],
            [
                'name' => '心理学',
                'description' => '認知心理学、社会心理学、発達心理学、臨床心理学等',
                'icon' => '🧠',
                'is_active' => true
            ],
            [
                'name' => '社会学',
                'description' => '社会理論、社会調査、社会問題、文化研究等',
                'icon' => '👥',
                'is_active' => true
            ],
            [
                'name' => '文学・言語学',
                'description' => '日本文学、外国文学、言語学、文献学等',
                'icon' => '📚',
                'is_active' => true
            ],
            [
                'name' => '歴史学',
                'description' => '日本史、世界史、考古学、文化史等',
                'icon' => '📜',
                'is_active' => true
            ],
            [
                'name' => '芸術・デザイン',
                'description' => '美術、音楽、映像、グラフィックデザイン等',
                'icon' => '��',
                'is_active' => true
            ],
            [
                'name' => '教育学',
                'description' => '教育理論、教育方法、カリキュラム開発、教育評価等',
                'icon' => '🎓',
                'is_active' => true
            ],
            [
                'name' => '法学・政治学',
                'description' => '憲法、民法、刑法、国際法、政治理論等',
                'icon' => '⚖️',
                'is_active' => true
            ],
            [
                'name' => 'その他・学際',
                'description' => '複数分野にまたがる研究や特殊な研究領域',
                'icon' => '🌐',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
