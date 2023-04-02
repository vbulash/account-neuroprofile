<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Тест
 *
 * @property string $content
 */
class Test extends Model {
	use HasFactory, TestFields;

	protected $fillable = [
		'content'
	];

	public function contract(): BelongsTo {
		return $this->belongsTo(Contract::class);
	}

	public function history(): HasMany {
		return $this->hasMany(History::class);
	}

	public function getCardFields(): iterable {
		$result = [];
		$content = json_decode($this->content);
		if (isset($content->card)) {
			$card = (array) $content->card;
			foreach (self::$fields as $field) {
				$name = $field['name'];
				$label = $field['label'];
				if (array_key_exists($name, $card))
					$result[$name] = $label;
			}
		}
		return $result;
	}
}