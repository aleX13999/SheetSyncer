<?php

namespace App\Console\Commands;

use App\Application\Note\NoteSynchronization;
use App\Services\Synchronization\Csv\CsvSynchronization;
use Illuminate\Console\Command;

class SyncNotesCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:notes-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize notes data from database with csv file';

    public function __construct(
        private readonly CsvSynchronization $csvSynchronization,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Starting synchronization with csv file...');

        $noteSync = new NoteSynchronization($this->csvSynchronization);
        $noteSync->sync();

        $this->info('Synchronization completed.');
    }
}
