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
        Schema::create('coverage_option_quote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coverage_option_id')->constrained('coverage_options');
            $table->foreignId('quote_id')->constrained('quotes');
            $table->timestamps();

            $table->unique(['quote_id', 'coverage_option_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coverage_option_quote');
    }
};
