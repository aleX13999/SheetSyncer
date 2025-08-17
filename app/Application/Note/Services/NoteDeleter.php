<?php

namespace App\Application\Note\Services;

use App\Application\Note\Exception\NoteException;
use App\Models\Note;

readonly class NoteDeleter
{
    public function __construct(
        private NoteGetter $getter,
    ) {}

    /**
     * @throws NoteException
     */
    public function delete(int $id): void
    {
        $note = $this->getter->get($id);

        $note->delete();
    }

    /**
     * @throws NoteException
     */
    public function deleteAll(): void
    {
        try {
            Note::truncate();
        } catch (\Exception $e) {
            throw new NoteException($e->getMessage());
        }
    }
}
