<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Nette\Schema\ValidationException;

class ImportStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(!in_array($this->file->getClientOriginalExtension(), ['xlsx'])){
            throw \Illuminate\Validation\ValidationException::withMessages(['Incorrect file extension']);
        }

        return [
            'file' => 'required|file',
            'type' => 'required|integer|in:1,2',
        ];
    }
}
