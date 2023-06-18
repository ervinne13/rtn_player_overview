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
        Schema::create('player_overviews', function (Blueprint $table) {
            $table->unsignedBigInteger('player_id')
                ->constrained(
                    table: 'teams',
                    indexName: 'player_overviews_player_id'
                );
            $table->integer('param_id')
                ->constrained(
                    table: 'teams',
                    indexName: 'player_overviews_param_id'
                );
            $table->integer('match_year');

            $table->string('football_name');
            // No need to use param_name, let's reflect the intended output instead as
            // this is just a denormalization of the param_name
            $table->string('statistic');
            $table->decimal('value'); // TODO: double check with proctors later for precision
            $table->timestamps();

            $table->primary(['player_id', 'param_id', 'match_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_overviews');
    }
};
