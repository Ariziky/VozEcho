<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enregistrement extends Model
{
    use HasUuids;

    protected $fillable = [
        'path',
        'size',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function listenings(): HasMany
    {
        return $this->hasMany(Listening::class, 'enregistrement_id');
    }
}
