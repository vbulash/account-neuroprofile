<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OGRNControlSumRule implements ValidationRule {
	/**
	 * Run the validation rule.
	 *
	 * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
	 */
	public function validate(string $attribute, mixed $value, Closure $fail): void {
		// Алгоритм
		// https://www.sberbank.ru/ru/s_m_business/pro_business/ogrn-i-ogrnip-chto-eto-takoe-i-kak-proverit-ogrn-po-inn/
		$baselen = strlen($value);
		$common = substr($value, 0, $baselen - 1);
		$control = substr($value, $baselen - 1, 1);
		//
		$step1 = intval($common) / ($baselen - 2);
		$step2 = intval($step1) * ($baselen - 2);
		;
		$step3 = (intval($common) - $step2) % 10;
		$passed = ($step3 == $control);

		if (!$passed)
			$fail('Проверьте ОГРН / ОГРНИП - контрольная сумма неверна');
	}
}