<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContractRequest;
use App\Models\Client;
use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ContractController extends Controller {

	public function show(int $client, int $contract) {
		return $this->edit($client, $contract, false);
	}

	public function edit(int $client, int $contract, bool $edit = true) {
		$_client = Client::findOrFail($client);
		$_contract = Contract::findOrFail($contract);

		$heading = sprintf("Информация по договору № %s клиента &laquo;%s&raquo;", $_contract->number, $_client->getTitle());
		$view = $edit ? 'contracts.edit' : 'contracts.show';
		return view($view, [
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