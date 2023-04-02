<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * История прохождения тестирования
 *
 * @property \Datetime $done
 * @property string $card
 * @property string $code
 */
class History extends Model {
	use HasFactory;

	protected $table = 'history';

	protected $fillable = [
		'done',
		'card',
		'code'
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

	public function getCardValues(?array $fields): iterable {
		$result = [];
		if (!isset($fields))
			return $result;
		if (isset($this->card)) {
			$card = json_decode($this->card, true);
			foreach ($card as $key => $value) {
				if (array_key_exists($key, $fields))
					$result[$key] = $value;
			}
		}
		return $result;
	}
}