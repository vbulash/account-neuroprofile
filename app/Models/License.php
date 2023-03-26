<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Лицензия
 *
 * @property string $pkey
 * @property int $status
 */
class License extends Model {
    use HasFactory;

    protected $fillable = [
        'pkey',
        'status',
    ];

    public function contract(): BelongsTo {
        return $this->belongsTo(Contract::class);
    }
}