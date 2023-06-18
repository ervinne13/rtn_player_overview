<?php

namespace Database\Seeders;

use App\Models\MatchResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatchCSVSeeder extends Seeder
{
    public function __construct(
        private CSVReader $csvReader
    ) {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = $this->csvReader->readRows(storage_path('seeders/matches.csv'), ';');
        foreach ($rows as $row) {
            $matchDate = date_create_from_format('Y-m-d H:i', $row['match_date']);
            $matchResult = [
                'id' => $row['id'],
                'match_name' => $row['match_name'],
                'match_date' =>  $matchDate,
                'team1_id' => $row['team1_id'],
                'team2_id' => $row['team2_id'],
            ];

            if ($row['team1_score'] != '\\N') {
                $matchResult['team1_score'] = $row['team1_score'];
            }

            if ($row['team2_score'] != '\\N') {
                $matchResult['team2_score'] = $row['team2_score'];
            }

            MatchResult::create($matchResult);
        }
    }
}
