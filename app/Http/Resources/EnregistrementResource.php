<?php

namespace App\Http\Resources;

use App\Models\Enregistrement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/** @mixin Enregistrement */
class EnregistrementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'path' => Str::afterLast(basename($this->path), '/'),
        ];
    }
}
