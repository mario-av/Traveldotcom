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
        Schema::create('review_histories', function (Blueprint $col) {
            $col->id();
            $col->foreignId('review_id')->constrained('reviews')->onDelete('cascade');
            $col->text('content');
            $col->integer('rating');
            $col->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_histories');
    }
};
