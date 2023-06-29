<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnregistrementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'attachment' => [
                'required',
                'mimetypes:audio/webm'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'attachment' => [
                'required' => 'Veuillez attacher un fichier',
                'mimetypes' => 'Le format de fichier est invalide (format accepté : audio/webm)',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
