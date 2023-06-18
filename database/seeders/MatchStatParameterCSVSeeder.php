<?php

namespace Database\Seeders;

use App\Models\MatchStatParameter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MatchStatParameterCSVSeeder extends Seeder
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
        $rows = $this->getParamRows();
        foreach ($rows as $row) {
            MatchStatParameter::create([
                'id' => $row['id'],
                'name' => $row['name']
            ]);
        }
    }

    private function getParamRows(): array
    {
        $rows = $this->csvReader->readRows(storage_path('seeders/match_stats.csv'), ';');
        $pivotObject = [];

        foreach ($rows as $row) {
            $pivotObject[$row['param_id']] = [
                'id' => $row['param_id'],
                'name' => $row['param_name'],
            ];
        }

        return array_values($pivotObject);
    }
}
