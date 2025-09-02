<?php

namespace App\Services\Synchronization\Csv;

use App\Application\Synchronization\SynchronizationInterface;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\NoFileException;

class CsvSynchronization implements SynchronizationInterface
{
    public function loadData(): array
    {
        $fp = null;
        try {
            $filePath = storage_path('notes.csv');

            $fp = fopen($filePath, 'r');
            if (!$fp) {
                throw new NoFileException("not found");
            }

            $data = [];

            while (($row = fgetcsv($fp, separator: ';')) !== false) {
                $data[] = $row;
            }

            return $data;

        } catch (Exception $e) {
            throw new NoFileException("not found");
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
            $filePath = storage_path('notes.csv');

            $fp = fopen($filePath, 'w');
            if (!$fp) {
                throw new NoFileException("Unable to open file");
            }

            foreach ($data as $item) {
                fputcsv($fp, $item, ';');
            }

        } finally {
            if (is_resource($fp)) {
                fclose($fp);
            }
        }
    }
}
