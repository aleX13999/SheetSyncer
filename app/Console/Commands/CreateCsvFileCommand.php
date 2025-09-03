<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SplFileObject;

class CreateCsvFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:create {path=app/notes.csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CSV file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        try {
            $path = $this->argument('path');

            $storagePath = 'storage/' . $path;

            $dir = dirname($storagePath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $file = new SplFileObject($storagePath, 'w');

            $file->fputcsv(['id', 'title', 'description', 'comment']); // Заголовок

            $this->info('File created with path: ' . $storagePath);

        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
