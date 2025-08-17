<?php

namespace App\Application\Note\Services;

use Database\Factories\NoteFactory;

readonly class NoteGenerator
{
    public function __construct(
        private NoteFactory $noteFactory,
    ) {}

    public function generate(int $count = 1000): void
    {
        $this->noteFactory->count($count)->create();
    }
}
