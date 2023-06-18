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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->string('match_name');
            $table->dateTime('match_date');
            $table->unsignedBigInteger('team1_id')
                ->constrained(
                    table: 'teams',
                    indexName: 'matches_team1_id'
                );
            $table->integer('team1_score')
                ->nullable(true);

            $table->unsignedBigInteger('team2_id')
                ->constrained(
                    table: 'teams',
                    indexName: 'matches_team2_id'
                );
            $table->integer('team2_score')
                ->nullable(true);                

            $table->timestamps();

            $table->index('match_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
