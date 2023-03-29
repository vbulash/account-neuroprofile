<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model {
    use HasFactory;

    protected $table = 'history';

    public function license(): BelongsTo {
        return $this->belongsTo(License::class);
    }
}