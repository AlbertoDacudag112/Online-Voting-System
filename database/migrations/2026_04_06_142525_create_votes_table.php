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
        Schema::create('votes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('election_id')->constrained()->cascadeOnDelete();
        $table->foreignId('position_id')->constrained()->cascadeOnDelete();
        $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
        $table->string('ip_address')->nullable();
        $table->datetime('voted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
