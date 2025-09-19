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
        Schema::create('draws', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('lottery_id');
            $table->timestamp('draw_at');
            $table->jsonb('result_numbers')->nullable();
            $table->enum('status', ['pending', 'settled'])->default('pending');
            $table->timestamps();

            $table->foreign('lottery_id')->references('id')->on('lotteries')->cascadeOnDelete();
            $table->index(['lottery_id', 'draw_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draws');
    }
};
