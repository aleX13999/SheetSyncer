<?php

namespace App\Application\Note\Validator;

use App\Application\Note\DTO\NoteCreateData;
use App\Application\Note\Exception\NoteValidationException;

readonly class NoteCreateValidator
{
    private const ERROR_MESSAGE = 'Creating error: ';

    public function __construct(
        private NotePropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws NoteValidationException
     */
    public function validate(NoteCreateData $noteCreateData): void
    {
        try {
            $this->propertyValidator->validateStatus($noteCreateData->getStatus());
        } catch (NoteValidationException $e) {
            throw new NoteValidationException(self::ERROR_MESSAGE . $e->getMessage());
        }
    }
}
