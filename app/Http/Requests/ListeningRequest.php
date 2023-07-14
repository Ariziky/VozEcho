<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListeningRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'uuid', Rule::exists('enregistrements', 'uuid')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
