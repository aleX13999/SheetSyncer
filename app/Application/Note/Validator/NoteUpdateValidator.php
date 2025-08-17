<?php

namespace App\Application\Note\Validator;

use App\Application\Note\DTO\NoteUpdateData;
use App\Application\Note\Exception\NoteValidationException;

readonly class NoteUpdateValidator
{
    private const ERROR_MESSAGE = 'Updating error: ';

    public function __construct(
        private NotePropertyValidator $propertyValidator,
    ) {}

    /**
     * @throws NoteValidationException
     */
    public function validate(NoteUpdateData $updateData): void
    {
        if ($updateData->hasStatus()) {
            try {
                $this->propertyValidator->validateStatus($updateData->getStatus());
            } catch (NoteValidationException $e) {
                throw new NoteValidationException(self::ERROR_MESSAGE . $e->getMessage());
            }
        }
    }
}
