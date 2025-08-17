<?php

namespace App\Repositories;

use App\Application\Note\Repository\NoteRepositoryInterface;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository implements NoteRepositoryInterface
{
    public function getOne(int $id): ?Note
    {
        return Note::find($id);
    }

    public function getAll(): Collection
    {
        return Note::all();
    }
}
