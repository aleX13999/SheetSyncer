<?php

namespace App\Http\Requests\Note;

use App\Application\Note\Enum\NoteStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class NoteCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'       => 'required|string',
            'description' => 'required|string',
            'status'      => ['required', new Enum(NoteStatusEnum::class)],
        ];
    }
}
