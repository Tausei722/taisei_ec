<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laboratory_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratory_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title'); // レビューのタイトル
            $table->text('content'); // レビュー内容
            $table->integer('overall_rating'); // 総合評価 (1-5)
            $table->integer('research_rating')->nullable(); // 研究内容の評価 (1-5)
            $table->integer('supervision_rating')->nullable(); // 指導の評価 (1-5)
            $table->integer('environment_rating')->nullable(); // 研究環境の評価 (1-5)
            $table->integer('career_rating')->nullable(); // 進路サポートの評価 (1-5)
            $table->string('academic_year')->nullable(); // 在籍年度（例：2023年度）
            $table->string('degree_type')->nullable(); // 学位種類（学士、修士、博士）
            $table->text('research_topic')->nullable(); // 研究テーマ
            $table->text('career_path')->nullable(); // 進路情報
            $table->json('images')->nullable(); // 画像
            $table->date('graduation_date')->nullable(); // 卒業/修了日
            $table->boolean('is_verified')->default(false); // 認証済みかどうか
            $table->boolean('is_anonymous')->default(false); // 匿名投稿かどうか
            $table->integer('helpful_count')->default(0); // 参考になったカウント
            $table->timestamps();

            // 複合インデックス（一人一つの研究室に対して一つのレビューのみ）
            $table->unique(['laboratory_id', 'user_id']);
            $table->index('overall_rating');
            $table->index(['laboratory_id', 'overall_rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratory_reviews');
    }
};
