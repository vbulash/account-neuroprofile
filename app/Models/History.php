<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * История прохождения тестирования
 *
 * @property \Datetime $done
 */
class History extends Model {
	use HasFactory;

	protected $table = 'history';

	protected $fillable = [
		'done',
	];

	protected $casts = [
		'done' => 'datetime'
	];

	public function license(): BelongsTo {
		return $this->belongsTo(License::class);
	}

	public function test(): BelongsTo {
		return $this->belongsTo(Test::class);
	}
}