<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed|null $enregistrement
 */
class Listening extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'enregistrement_id',
        'ip_address',
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function enregistrement(): BelongsTo
    {
        return $this->belongsTo(Enregistrement::class);
    }
}
