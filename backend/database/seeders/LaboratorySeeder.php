<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ユーザーを作成
        $users = [
            [
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'password' => bcrypt('password123'),
                'status' => 'graduate',
            ],
            [
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
                'password' => bcrypt('password123'),
                'status' => 'current_student',
            ],
            [
                'name' => '田中一郎',
                'email' => 'tanaka@example.com',
                'password' => bcrypt('password123'),
                'status' => 'graduate',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // 研究室を作成
        $laboratories = [
            [
                'faculty' => '工学部',
                'department' => '情報工学科',
                'course' => '人工知能コース',
                'research_overview' => '機械学習と深層学習を用いた画像認識システムの研究を行っています。特にCNNやTransformerを使った最新の手法を研究しています。',
            ],
            [
                'faculty' => '工学部',
                'department' => '情報工学科',
                'course' => 'ネットワークコース',
                'research_overview' => 'IoTデバイスのセキュリティとネットワークプロトコルの最適化に関する研究を行っています。',
            ],
            [
                'faculty' => '理学部',
                'department' => '数学科',
                'course' => null,
                'research_overview' => '代数幾何学と数論の理論研究を行っています。特に楕円曲線と暗号理論への応用を研究しています。',
            ],
            [
                'faculty' => '工学部',
                'department' => '機械工学科',
                'course' => 'ロボティクスコース',
                'research_overview' => '自律移動ロボットの制御システムと環境認識技術の開発を行っています。',
            ],
        ];

        foreach ($laboratories as $labData) {
            DB::table('laboratories')->insert(array_merge($labData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // レビューを作成
        $reviews = [
            [
                'research_content' => 'CNNを使った医療画像診断システムの開発を行いました。PyTorchを使って実装し、精度95%を達成できました。',
                'laboratory_id' => 1,
                'user_id' => 1,
                'overall_rating' => 5,
                'professor_atmosphere' => 5,
                'senior_atmosphere' => 4,
                'core_time' => 3,
                'laboratory_connection' => 4,
                'evaluation_strictness' => 3,
                'job_hunting_situation' => 5,
                'research_funding' => 5,
                'conference_frequency' => 4,
                'extracurricular_interaction' => 5,
                'helpful_count' => 0,
            ],
            [
                'research_content' => 'IoTデバイス間の暗号化通信プロトコルの設計を行いました。実装は大変でしたが、先輩のサポートが手厚かったです。',
                'laboratory_id' => 2,
                'user_id' => 2,
                'overall_rating' => 4,
                'professor_atmosphere' => 4,
                'senior_atmosphere' => 5,
                'core_time' => 4,
                'laboratory_connection' => 3,
                'evaluation_strictness' => 4,
                'job_hunting_situation' => 4,
                'research_funding' => 3,
                'conference_frequency' => 3,
                'extracurricular_interaction' => 4,
                'helpful_count' => 0,
            ],
            [
                'research_content' => '楕円曲線上の有理点の研究を行いました。理論研究が中心で、数学的な厳密性が求められます。',
                'laboratory_id' => 3,
                'user_id' => 3,
                'overall_rating' => 4,
                'professor_atmosphere' => 5,
                'senior_atmosphere' => 4,
                'core_time' => 2,
                'laboratory_connection' => 2,
                'evaluation_strictness' => 5,
                'job_hunting_situation' => 3,
                'research_funding' => 3,
                'conference_frequency' => 2,
                'extracurricular_interaction' => 3,
                'helpful_count' => 0,
            ],
            [
                'research_content' => 'SLAMアルゴリズムを使った自律移動ロボットの開発。ハードウェアとソフトウェアの両方を扱えて楽しかったです。',
                'laboratory_id' => 4,
                'user_id' => 1,
                'overall_rating' => 5,
                'professor_atmosphere' => 4,
                'senior_atmosphere' => 5,
                'core_time' => 4,
                'laboratory_connection' => 5,
                'evaluation_strictness' => 3,
                'job_hunting_situation' => 5,
                'research_funding' => 4,
                'conference_frequency' => 3,
                'extracurricular_interaction' => 5,
                'helpful_count' => 0,
            ],
            [
                'research_content' => 'Transformerを使った自然言語処理の研究。最新の論文を追うのが大変でしたが、やりがいがありました。',
                'laboratory_id' => 1,
                'user_id' => 2,
                'overall_rating' => 4,
                'professor_atmosphere' => 4,
                'senior_atmosphere' => 4,
                'core_time' => 4,
                'laboratory_connection' => 4,
                'evaluation_strictness' => 4,
                'job_hunting_situation' => 4,
                'research_funding' => 5,
                'conference_frequency' => 5,
                'extracurricular_interaction' => 4,
                'helpful_count' => 0,
            ],
        ];

        foreach ($reviews as $reviewData) {
            DB::table('laboratory_reviews')->insert(array_merge($reviewData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // 好評価データを作成
        $helpfulData = [
            ['laboratory_review_id' => 1, 'user_id' => 2],
            ['laboratory_review_id' => 1, 'user_id' => 3],
            ['laboratory_review_id' => 2, 'user_id' => 1],
            ['laboratory_review_id' => 3, 'user_id' => 2],
            ['laboratory_review_id' => 4, 'user_id' => 2],
            ['laboratory_review_id' => 4, 'user_id' => 3],
        ];

        foreach ($helpfulData as $helpful) {
            DB::table('laboratory_review_helpful')->insert(array_merge($helpful, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // helpful_countを更新
        DB::table('laboratory_reviews')->where('id', 1)->update(['helpful_count' => 2]);
        DB::table('laboratory_reviews')->where('id', 2)->update(['helpful_count' => 1]);
        DB::table('laboratory_reviews')->where('id', 3)->update(['helpful_count' => 1]);
        DB::table('laboratory_reviews')->where('id', 4)->update(['helpful_count' => 2]);
    }
}
