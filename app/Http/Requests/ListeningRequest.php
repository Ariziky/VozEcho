<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListeningRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => ['required', 'uuid'],
            'ip_address' => ['required', 'ip'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
