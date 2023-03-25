<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Контракт клиента
 *
 * @property string $number
 * @property string $invoice
 * @property string $start
 * @property string $end
 * @property string $email
 * @property bool $commercial
 * @property string $mkey
 * @property int $license_count
 * @property string $url
 * @property int $status
 */
class Contract extends Model {
    use HasFactory;

    protected $fillable = [
        'number',
        'invoice',
        'start',
        'end',
        'email',
        'commercial',
        'mkey',
        'license_count',
        'url',
        'status',
    ];

    public function getTitle(): string {
        return 'Договор № ' . $this->number;
    }

    public function client(): BelongsTo {
        return $this->belongsTo(Client::class);
    }
}
