<?php

namespace App\Application\Note\Services;

use App\Application\Note\Exception\NoteException;
use App\Application\Note\Repository\NoteRepositoryInterface;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

readonly class NoteGetter
{
    public function __construct(
        private NoteRepositoryInterface $noteRepository,
    ) {}

    /**
     * @throws NoteException
     */
    public function get(int $id): Note
    {
        $note = $this->noteRepository->getOne($id);

        if (!$note) {
            throw new NoteException("Note not found");
        }

        return $note;
    }

    public function getOne(int $id): ?Note
    {
        return $this->noteRepository->getOne($id);
    }

    public function getAll(): Collection
    {
        return $this->noteRepository->getAll();
    }
}
