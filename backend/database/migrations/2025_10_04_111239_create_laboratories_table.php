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
            $table->string('faculty'); // 学部
            $table->string('department'); // 学科
            $table->string('course')->nullable(); // コース(nullable)
            $table->text('research_overview'); // 研究概要
            $table->timestamps();

            // インデックス
            $table->index(['faculty', 'department']);
            $table->index('course');
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
