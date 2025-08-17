<?php

namespace App\Application\Note\Services;

use App\Application\Note\DTO\NoteUpdateData;
use App\Application\Note\Enum\NoteStatusEnum;
use App\Application\Note\Exception\NoteException;
use App\Application\Note\Exception\NoteValidationException;
use App\Application\Note\Validator\NoteUpdateValidator;
use App\Models\Note;
use Illuminate\Database\Eloquent\MassAssignmentException;

readonly class NoteUpdater
{
    public function __construct(
        private NoteUpdateValidator $validator,
        private NoteGetter          $getter,
    ) {}

    /**
     * @throws NoteValidationException
     * @throws NoteException
     */
    public function update(NoteUpdateData $updateData): Note
    {
        $this->validator->validate($updateData);

        $note = $this->getter->get($updateData->getId());

        $data = [];

        if ($updateData->hasTitle()) {
            $data['title'] = $updateData->getTitle();
        }

        if ($updateData->hasDescription()) {
            $data['description'] = $updateData->getDescription();
        }

        if ($updateData->hasStatus()) {
            $data['status'] = NoteStatusEnum::from($updateData->getStatus());
        }

        try {
            $note->fill($data);
            $note->save();
        } catch (MassAssignmentException $e) {
            throw new NoteException($e->getMessage());
        }

        return $note;
    }
}
