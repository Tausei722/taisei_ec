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
            $table->text('research_content'); // 研究内容
            $table->foreignId('laboratory_id')->constrained()->onDelete('cascade'); // 研究室(研究室DB foreign)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // 投稿者(ユーザーDB foreign)
            $table->integer('overall_rating'); // 総合評価 (1-5)
            $table->integer('professor_atmosphere'); // 先生の雰囲気(ブラックかどうか) (1-5)
            $table->integer('senior_atmosphere'); // 先輩の雰囲気(ブラックかどうか) (1-5)
            $table->integer('core_time'); // コアタイム(研究室への拘束時間) (1-5)
            $table->integer('laboratory_connection'); // 研究室のコネ(企業へのつながり) (1-5)
            $table->integer('evaluation_strictness'); // 評価の厳しさ (1-5)
            $table->integer('job_hunting_situation'); // 就活事情 (1-5)
            $table->integer('research_funding'); // 研究費用の充実度 (1-5)
            $table->integer('conference_frequency'); // 学会への出撃回数 (1-5)
            $table->integer('extracurricular_interaction'); // 研究外での交流 (1-5)
            $table->integer('helpful_count')->default(0); // 好評価数
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
