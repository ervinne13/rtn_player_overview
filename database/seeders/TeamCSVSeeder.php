<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamCSVSeeder extends Seeder
{
    public function __construct(
        private CSVReader $csvReader
    )
    { }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = $this->csvReader->readRows(storage_path('seeders/teams.csv'), ';');
        foreach($rows as $row) {
            Team::create([
                'id' => $row['id'],
                'name' => $row['name'],
                'short_name' => $row['short_name']
            ]);
        }
    }
}
