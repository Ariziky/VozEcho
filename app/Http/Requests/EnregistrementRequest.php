<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class EnregistrementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'attachment' => [
                'required',
                File::types(['webm', 'mp3', 'wav'])
                    ->max(2 * 1024),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'attachment' => [
                'required' => 'Veuillez attacher un fichier',
                'max' => 'Fichier trop lourd',
                'mimetypes' => 'Le format du fichier est invalide',
                'mimes' => 'Le format du fichier est invalide',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
