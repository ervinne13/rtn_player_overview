<?php

namespace Database\Seeders;

use App\Models\MatchStat;
use Illuminate\Database\Seeder;

class MatchStatCSVSeeder extends Seeder
{
    public function __construct(
        private CSVReader $csvReader
    ) {
    }

    /**
     * TODO: DRY, duplicate calls to insert and flush, check to see if 
     * it's something we can consolidate
     * Run the database seeds.
     */
    public function run(): void
    {
        // Unfortunately, this process is too large for 1 transaction
        // let's rely on flush instead (automatically done whenever we migrate:refresh)

        $bufferSize = 10000;
        $header = null;
        $data = array();

        $filename = storage_path('seeders/match_stats.csv');

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 4096, ";")) !== false) {
                if (!$header) {
                    // Note `preg_replace` below. Excel sometimes adds in an invisible 
                    // character that messes up our keys: 
                    // https://stackoverflow.com/questions/43414804/first-key-of-php-associative-array-returns-undefined-index-when-parsed-from-csv
                    $header = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $row);
                } else {
                    $data[] = array_combine($header, $row);
                }

                if (count($data) >= $bufferSize) {
                    // insert and flush                    
                    MatchStat::insert(array_map(function ($row) {
                        return [
                            'match_id' => $row['match_id'],
                            'team_id' => $row['team_id'],
                            'player_id' => $row['player_id'],
                            'param_id' => $row['param_id'],
                            'value' => $row['value']
                        ];
                    }, $data));
                    $rowCount = count($data);
                    print("{$rowCount} rows inserted.\n");

                    $data = [];
                }
            }
            fclose($handle);

            // Insert unflushed data
            if (count($data) > 0) {
                MatchStat::insert(array_map(function ($row) {
                    return [
                        'match_id' => $row['match_id'],
                        'team_id' => $row['team_id'],
                        'player_id' => $row['player_id'],
                        'param_id' => $row['param_id'],
                        'value' => $row['value']
                    ];
                }, $data));
                $rowCount = count($data);
                print("{$rowCount} rows inserted.\n");
            }
        }
    }
}
