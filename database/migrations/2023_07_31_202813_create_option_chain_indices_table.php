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
        Schema::create('option_chain_indices', function (Blueprint $table) {
            $table->id();

            $table->string('symbol');
            $table->dateTime('time');

            $table->decimal('total_changein_open_interest_ce', 10, 4);
            $table->decimal('total_changein_open_interest_pe', 10, 4);

            $table->decimal('total_open_interest_ce', 10, 4);
            $table->decimal('total_open_interest_pe', 10, 4);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('option_chain_indices');
    }
};
