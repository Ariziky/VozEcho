<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class EnregistrementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ip_address' => ['required', 'ip'],
            'attachment' => [
                'required',
                'file',
                File::types(['webm', 'mp3']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'attachment' => [
                'required' => 'Veuillez attacher un fichier',
                'file' => 'Veuillez charger un fichier',
                'mimetypes' => 'Le format de fichier est invalide (format accepté : .webm)',
                'mimes' => '',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
