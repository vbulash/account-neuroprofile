<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OGRNRule implements ValidationRule {
	/**
	 * Run the validation rule.
	 *
	 * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
	 */
	public function validate(string $attribute, mixed $value, Closure $fail): void {
		$passed = false;
		if (!is_numeric($value))
			$passed = false; // Не цифры
		if (strlen($value) == 13)
			$passed = true; // Юридические лица
		if (strlen($value) == 15)
			$passed = true; // Индивидуальные предприниматели

		if (!$passed)
			$fail('ОГРН должен состоять из 13 цифр (для юридических лиц) или 15 цифр (для ИП)');
	}
}