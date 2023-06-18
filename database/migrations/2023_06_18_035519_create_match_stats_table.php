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
        Schema::create('match_stats', function (Blueprint $table) {
            $table->unsignedBigInteger('match_id')
                ->constrained(
                    table: 'matches',
                    indexName: 'match_stats_match_id'
                );

            $table->unsignedBigInteger('team_id')
                ->constrained(
                    table: 'teams',
                    indexName: 'match_stats_team_id'
                );

            $table->unsignedBigInteger('player_id')
                ->constrained(
                    table: 'players',
                    indexName: 'match_stats_player_id'
                );

            $table->integer('param_id')
                ->constrained(
                    table: 'match_stat_parameter',
                    indexName: 'match_stats_param_id'
                );

            $table->decimal('value'); // TODO: double check with proctors later for precision

            $table->timestamps();

            //  Composite key
            $table->primary(['match_id', 'team_id', 'player_id', 'param_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_stats');
    }
};
