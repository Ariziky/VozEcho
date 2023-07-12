<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ip_address' => ['required', 'ip'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
