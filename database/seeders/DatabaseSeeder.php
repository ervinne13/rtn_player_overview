<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $this->runSeederSequentially();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }

    private function runSeederSequentially()
    {
        $this->call([
            PlayerCSVSeeder::class,
            TeamCSVSeeder::class,
            MatchCSVSeeder::class,
            MatchStatParameterCSVSeeder::class,
            MatchStatCSVSeeder::class // Takes about 3-5 minutes
        ]);
    }
}
