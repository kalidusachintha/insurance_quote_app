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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_of_travelers');
            $table->decimal('total_price', 10, 2);
            $table->ipAddress('client_ip');
            $table->string('user_agent');
            $table->timestamps();

            $table->index('destination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
