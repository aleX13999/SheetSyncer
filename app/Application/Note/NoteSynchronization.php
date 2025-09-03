<?php

namespace App\Application\Note;

use App\Application\Synchronization\SynchronizationInterface;
use App\Models\Note;

readonly class NoteSynchronization
{
    public function __construct(
        private SynchronizationInterface $synchronization,
    ) {}

    public function sync(): void
    {
        $rows = $this->synchronization->loadData();

        $headers = array_shift($rows);

        $oldData = [];
        $newData = [];

        foreach ($rows as $row) {
            $oldData[$row[0]] = $row;
        }

        $allowedNotes = Note::allowed()->get();

        foreach ($allowedNotes as $allowedNote) {
            if (isset($oldData[$allowedNote->id])) {
                $newData[] = $oldData[$allowedNote->id];
            } else {
                $newData[] = [
                    $allowedNote->id,
                    $allowedNote->title,
                    $allowedNote->description,
                ];
            }
        }

        $this->synchronization->appendData(array_merge([$headers], $newData));
    }
}
