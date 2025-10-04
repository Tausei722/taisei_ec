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
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 研究室名
            $table->text('description'); // 研究室の説明
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // 研究分野カテゴリ
            $table->string('university'); // 大学名
            $table->string('department'); // 学部・学科
            $table->string('professor_name'); // 指導教員名
            $table->string('professor_title')->nullable(); // 教員の役職（教授、准教授等）
            $table->text('research_fields'); // 研究分野（JSON形式）
            $table->string('lab_url')->nullable(); // 研究室のウェブサイト
            $table->string('email')->nullable(); // 連絡先メール
            $table->text('admission_info')->nullable(); // 入学・配属情報
            $table->text('career_info')->nullable(); // 進路情報
            $table->integer('student_count')->nullable(); // 学生数
            $table->decimal('average_rating', 3, 2)->default(0); // 平均評価
            $table->integer('total_reviews')->default(0); // 口コミ数
            $table->json('images')->nullable(); // 研究室の画像
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // インデックス
            $table->index(['university', 'department']);
            $table->index('professor_name');
            $table->index('average_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laboratories');
    }
};
