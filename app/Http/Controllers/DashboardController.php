<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
	public function index() {
		$heading = 'Информация по клиентам';
		$clients = Client::all()->sortBy('name');

		return view('dashboard', [
			'heading' => $heading,
			'clients' => $clients
		]);
	}

	public static function historyCount(int $client) {
		$query = DB::select(<<<EOS
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
	AND clients.id = :client
EOS,
			['client' => $client]
		);
		return count($query);
	}
}