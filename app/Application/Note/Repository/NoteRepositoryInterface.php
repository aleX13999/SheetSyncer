<?php

namespace App\Application\Note\Repository;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;

interface NoteRepositoryInterface
{
    public function getOne(int $id): ?Note;
    public function getAll(): Collection;
}
