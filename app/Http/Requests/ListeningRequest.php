<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListeningRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required'],
            'enregistrement_id' => ['required', 'integer'],
            'ip_address' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
