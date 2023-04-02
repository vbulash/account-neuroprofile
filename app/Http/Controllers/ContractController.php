<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContractRequest;
use App\Models\Client;
use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ContractController extends Controller {

	private function testAllLetter(int $count): string {
		$letter = ' ';
		if (($count < 10) || ($count > 20)) {
			$letter .= match ($count % 10) {
				1 => 'тестирование пройден',
				2, 3, 4 => 'тестирования пройдено',
				default => 'тестирований пройдено',
			};
		} else
			$letter .= 'тестирований пройдено';

		return $letter;
	}

	public function show(int $client, int $contract) {
		$_client = Client::findOrFail($client);
		$_contract = Contract::findOrFail($contract);

		$data = DB::select(<<<EOS
SELECT
	DATE(done) AS `date`,
	count(DATE(done)) AS total
FROM
	`history`,
	`tests`,
	`contracts`
WHERE
	`history`.`test_id` = `tests`.id
	AND `tests`.`contract_id` = `contracts`.id
	AND `contracts`.id = :contract
GROUP BY `date`
ORDER BY `date` ASC
LIMIT 14
EOS,
			['contract' => $contract]
		);

		$heading = sprintf("Информация по договору № %s клиента &laquo;%s&raquo;", $_contract->number, $_client->getTitle());

		return view('contracts.show', [
			'heading' => $heading,
			'contract' => $_contract,
			'reports' => $data,
		]);
	}

	public function edit(int $client, int $contract) {
		$_client = Client::findOrFail($client);
		$_contract = Contract::findOrFail($contract);

		$heading = sprintf("Информация по договору № %s клиента &laquo;%s&raquo;", $_contract->number, $_client->getTitle());
		return view('contracts.edit', [
			'heading' => $heading,
			'contract' => $_contract
		]);
	}

	public function update(Request $request, int $client, int $contract) {
		$data = $request->except(['_token', '_method']);

		Validator::make(
		data: $data,
		rules: [
				'number' => 'required',
				'invoice' => 'required',
				'start' => 'required|date',
				'end' => 'required|date|after:start',
				'url' => 'required|url'
			],
		attributes: [
				'number' => 'Номер договора',
				'invoice' => 'Номер оплаченного счета',
				'start' => 'Дата начала договора',
				'end' => 'Дата завершения договора',
				'url' => 'URL страницы сайта клиента'
			]
		)->validate();

		$_contract = Contract::findOrFail($contract);
		$_contract->update($data);

		session()->put('success', sprintf("Договор \"%s\" изменён", $_contract->number));

		return redirect()->route('clients.contracts.show', [
			'client' => $_contract->client->getKey(),
			'contract' => $_contract->getKey()
		]);
	}
}