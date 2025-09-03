<?php

namespace App\Services\Synchronization\Csv;

use App\Application\Synchronization\SynchronizationInterface;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

class CsvSynchronization implements SynchronizationInterface
{
    public function loadData(): array
    {
        $fp = null;
        try {
            $filePath = storage_path(env('CSV_PATH'));

            $fp = fopen($filePath, 'r');
            if (!$fp) {
                throw new NoFileException("Unable to open file");
            }

            $data = [];

            while (($row = fgetcsv($fp)) !== false) {
                $data[] = [
                    $row[0],
                    $row[1],
                    $row[2],
                    $row[3] ?? '',
                ];
            }

            return $data;

        } finally {
            if (is_resource($fp)) {
                fclose($fp);
            }
        }
    }

    public function appendData(array $data): void
    {
        $fp = null;
        try {
            $filePath = storage_path(env('CSV_PATH'));

            $fp = fopen($filePath, 'w');
            if (!$fp) {
                throw new NoFileException("Unable to open file");
            }

            foreach ($data as $item) {
                fputcsv($fp, $item);
            }

        } finally {
            if (is_resource($fp)) {
                fclose($fp);
            }
        }
    }
}
