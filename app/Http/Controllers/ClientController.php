<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Rules\INNRule;
use App\Rules\OGRNControlSumRule;
use App\Rules\OGRNRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller {
	public function show(int $client) {
		return $this->edit($client, false);
	}

	public function edit(int $client, bool $edit = true) {
		$_client = Client::findOrFail($client);
		$heading = sprintf("Информация по клиенту &laquo;%s&raquo;", $_client->getTitle());

		$view = $edit ? 'clients.edit' : 'clients.show';
		return view($view, [
			'heading' => $heading,
			'client' => $_client
		]);
	}

	public function update(Request $request, int $client) {
		$data = $request->except(['_token', '_method']);

		Validator::make(
		data: $data,
		rules: [
				'name' => 'required',
				'inn' => [
					'bail',
					'required',
					new INNRule
				],
				'ogrn' => [
					'bail',
					'required',
					new OGRNRule,
					new OGRNControlSumRule
				],
				'address' => 'required',
				'email' => [
					'required',
					'email'
				],
			],
		attributes: [
				'name' => 'Наименование',
				'inn' => 'ИНН',
				'ogrn' => 'ОГРН / ОГРНИП',
				'address' => 'Адрес',
				'email' => 'Электронная почта'
			]
		)->validate();

		$_client = Client::findOrFail($client);
		$_client->update($data);

		session()->put('success', sprintf("Клиент \"%s\" изменён", $_client->getTitle()));

		return redirect()->route('clients.show', [
			'client' => $_client->getKey(),
		]);
	}
}