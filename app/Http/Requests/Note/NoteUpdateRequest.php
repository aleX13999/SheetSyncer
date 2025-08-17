<?php

namespace App\Http\Requests\Note;

use App\Application\Note\Enum\NoteStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class NoteUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'sometimes|string',
            'description' => 'sometimes|string',
            'status'      => ['sometimes', new Enum(NoteStatusEnum::class)],
        ];
    }
}
