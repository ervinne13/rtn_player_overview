<?php

namespace App\Console\Commands;

use App\Services\PopulatePlayerOverview;
use Illuminate\Console\Command;

class PopulatePlayerOverviewAllYearsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rtn-player-overview:populate-all-years';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private PopulatePlayerOverview $populateSrvc
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->populateSrvc->populate();
    }
}
