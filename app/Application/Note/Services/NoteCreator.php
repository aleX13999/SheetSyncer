<?php

namespace App\Application\Note\Services;

use App\Application\Note\DTO\NoteCreateData;
use App\Application\Note\Enum\NoteStatusEnum;
use App\Application\Note\Exception\NoteException;
use App\Application\Note\Exception\NoteValidationException;
use App\Application\Note\Validator\NoteCreateValidator;
use App\Models\Note;

readonly class NoteCreator
{
    public function __construct(
        private NoteCreateValidator $validator,
    ) {}

    /**
     * @throws NoteValidationException
     * @throws NoteException
     */
    public function create(NoteCreateData $noteCreateData): Note
    {
        $this->validator->validate($noteCreateData);

        try {
            $note = Note::create(
                [
                    'title'       => $noteCreateData->getTitle(),
                    'description' => $noteCreateData->getDescription(),
                    'status'      => NoteStatusEnum::from($noteCreateData->getStatus()),
                ],
            );
        } catch (\Exception $e) {
            throw new NoteException($e->getMessage());
        }

        return $note;
    }
}
