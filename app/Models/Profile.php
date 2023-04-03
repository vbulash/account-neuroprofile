<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Нейропрофиль
 *
 * @property string $name
 */
class Profile extends Model {
	use HasFactory;

	protected $fillable = [
		'name'
	];

	public function fmptype(): BelongsTo {
		return $this->belongsTo(FMPType::class, 'fmptype_id');
	}

	public function blocks(): HasMany {
		return $this->hasMany(Block::class);
	}
}