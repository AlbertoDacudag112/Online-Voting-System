<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('elections', function (Blueprint $table) {
            $table->string('course')->nullable()->after('status');
        });

        Schema::table('candidates', function (Blueprint $table) {
            $table->string('course')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('elections', function (Blueprint $table) {
            $table->dropColumn('course');
        });
        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('course');
        });
    }
};