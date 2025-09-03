<?php

namespace App\Console\Commands;

use App\Services\Synchronization\Csv\CsvSynchronization;
use Illuminate\Console\Command;

class GetNotesCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:get-notes-csv {count? : The count of getting the notes}';

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
        $this->info('Getting notes data from database with csv file');

        $count = $this->argument('count');

        $data = $this->csvSynchronization->loadData();

        array_shift($data);

        if ($count > 0) {
            $notes = array_slice($data, 0, $count);
        } else {
            $notes = $data;
        }

        $bar = $this->output->createProgressBar(count($notes));
        $bar->start();

        $this->newLine();

        foreach ($notes as $note) {
            $this->line(array_shift($note) . ' / ' . array_pop($note));

            $bar->advance();
        }

        $this->newLine();

        $bar->finish();

        $this->info('Success!');
    }
}
