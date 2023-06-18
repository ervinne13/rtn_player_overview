<?php

namespace App\Services;

use App\Models\PlayerOverview;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

const EARLIEST_POSSIBLE_DATA = 2000;

/**
 * I haven't created it yet, but with this, we can selectively only flush and populate
 * specific years. This is useful as data from the past years do not change unless 
 * there are special cases like backtracking a player/team that we haven't tracked
 * before.
 */
class PopulatePlayerOverview
{
    public function flush(int $year = 0)
    {
        if ($year > EARLIEST_POSSIBLE_DATA) {
            PlayerOverview::whereMatchYear($year)->delete();
            Log::warning("Player overview for year {$year} is flushed");
        } else if ($year === 0) {
            PlayerOverview::query()->truncate();
            Log::warning("Player overview is flushed");
        } else {
            throw new Exception("Year {$year} is invalid for flushing data.");
        }
    }

    /**
     * TODO: DRY, duplicate calls to insert and flush, check to see if 
     * it's something we can consolidate
     */
    public function populate(int $year = 0)
    {
        $baseQuery = $this->generateBaseQuery();
        if ($year > EARLIEST_POSSIBLE_DATA) {
            $baseQuery->having('match_year', '=', $year);
        }

        // Unfortunately, this process is too large for 1 transaction
        // let's rely on flush instead

        $this->flush($year);
        // For some weird reason, get()->each does not work to convert the objects
        // to arrays, so let's manually create a new array instead for now.
        $playerOverviews = [];

        print("Now querying player overviews, this may take a while...\n");
        $playerOverviewsCollection = $baseQuery->get();
        $totalCount = count($playerOverviewsCollection);
        $currentRow = 0;
        print("Now creating {$totalCount} player overview records...\n");            
        $buffer = [
            'size' => 10000,
            'pointer' => 0,
            'content' => []
        ];
        $ignoredCount = 0;
        foreach ($playerOverviewsCollection as $playerOverview) {
            // Some records in the stats refer to players that are not recorded
            // in the players table, skip them
            if (!$playerOverview->football_name) {
                $ignoredCount++;
                continue;
            }

            if ($playerOverview->football_name == '\\N') {
                $playerOverview->football_name = "{$playerOverview->firstname} {$playerOverview->lastname}";
            }

            $buffer['content'][] = [
                'player_id' => $playerOverview->player_id,
                'param_id' => $playerOverview->param_id,
                'match_year' => $playerOverview->match_year,
                'football_name' => $playerOverview->football_name,
                'statistic' => $playerOverview->statistic,
                'value' => $playerOverview->value,
            ];                
            $buffer['pointer'] ++;
            $currentRow++;

            if ($buffer['pointer'] >= $buffer['size']) {
                // insert and flush
                PlayerOverview::insert($buffer['content']);
                $buffer['content'] = [];
                $buffer['pointer'] = 0;
                print("Created {$currentRow}/{$totalCount}\n");
            }            
        }

        //  Insert any unflushed data
        if (count($buffer['content']) > 0) {
            PlayerOverview::insert($buffer['content']);
            $buffer['content'] = [];
            print("Created {$totalCount} records\n");
            print("Done inserts, ignored {$ignoredCount}/{$totalCount} as they don't have corresponding player data\n");
        }
        
        Log::warning("Player overview data populated");
    }

    private function generateBaseQuery()
    {
        // Refer to sample: storage/queries/get_player_overview.sql
        return DB::table('match_stats')
            ->select([
                'player_id',
                'param_id',
                DB::raw('YEAR(matches.match_date) as match_year'),
                'football_name',
                'firstname',
                'lastname',
                'match_stat_parameters.name as statistic',
                DB::raw('SUM(match_stats.value) as value')
            ])
            ->leftJoin('matches', 'match_stats.match_id', '=', 'matches.id')
            ->leftJoin('players', 'match_stats.player_id', '=', 'players.id')
            ->leftJoin('match_stat_parameters', 'match_stats.param_id', '=', 'match_stat_parameters.id')
            ->groupByRaw('player_id, param_id, match_year');
    }
}
