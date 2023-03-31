<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class INNRule implements ValidationRule {
	public function validate(string $attribute, mixed $value, Closure $fail): void {
		$passed = false;
		if (!is_numeric($value))
			$passed = false; // Не цифры
		else if (strlen($value) == 10)
			$passed = true; // Юридические лица
		if (strlen($value) == 12)
			$passed = true; // Физические лица

		if (!$passed)
			$fail('Индивидуальный номер налогоплательщика должен состоять из 10 (юридические лица) или 12 (физические лица) цифр');
	}
}