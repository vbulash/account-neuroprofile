<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller {
	public function index() {
		$heading = 'Информация по клиентам';
		$clients = Client::all();

		return view('dashboard', [
			'heading' => $heading,
			'clients' => $clients
		]);
	}

	public function historyCount(int $client) {
		/*
		SELECT
		history.id
		FROM
		history,
		contracts,
		tests,
		clients
		WHERE
		history.test_id = tests.id
		AND tests.contract_id = contracts.id
		AND contracts.client_id = clients.id
		AND clients.id = 4;
		*/
	}
}