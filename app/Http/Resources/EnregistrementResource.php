<?php

namespace App\Http\Resources;

use App\Models\Enregistrement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Enregistrement */
class EnregistrementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'path' => $this->path,
        ];
    }
}
