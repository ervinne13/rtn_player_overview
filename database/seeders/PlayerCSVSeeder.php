<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;

class PlayerCSVSeeder extends Seeder
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
        $rows = $this->csvReader->readRows(storage_path('seeders/players.csv'), ';');
        foreach($rows as $row) {
            Player::create([
                'id' => $row['id'],
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'football_name' => $row['football_name'],
            ]);
        }        
    }
}
