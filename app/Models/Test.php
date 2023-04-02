<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Test extends Model {
	use HasFactory;

	public function contract(): BelongsTo {
		return $this->belongsTo(Contract::class);
	}

	public function history(): HasMany {
		return $this->hasMany(History::class);
	}
}