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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->integer('team_id')->nullable();
            $table->text('team_name')->nullable();
            $table->text('league_name')->nullable();
            $table->integer('league_level')->nullable();
            $table->text('nationality_name')->nullable();
            $table->integer('overall')->nullable();
            $table->integer('attack')->nullable();
            $table->integer('midfield')->nullable();
            $table->integer('defence')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
