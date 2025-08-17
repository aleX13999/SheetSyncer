<?php

namespace App\Application\Note\Validator;

use App\Application\Note\Enum\NoteStatusEnum;
use App\Application\Note\Exception\NoteValidationException;

readonly class NotePropertyValidator
{
    /**
     * @throws NoteValidationException
     */
    public function validateStatus(string $status): void
    {
        if (!NoteStatusEnum::tryFrom($status)) {
            throw new NoteValidationException("Invalid note status");
        }
    }
}
