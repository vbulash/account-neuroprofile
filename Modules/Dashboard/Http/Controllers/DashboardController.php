<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Auth\RoleName;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
	public function index() {
		if (!auth()->user()->hasRole(RoleName::ADMIN->value)) {
			$allowed = new Collection();
			$id = 0;
			foreach (Client::all()->sortBy('name') as $client)
				if (auth()->user()->hasPermissionTo('clients.show.' . $client->getKey())) {
					$allowed->add($client);
					$id = $client->getKey();
				}

			if ($allowed->count() == 1)
				return redirect()->route('clients.show', ['client' => $id]);
		}

		$heading = 'Информация по клиентам';
		$clients = Client::all()->sortBy('name');

		return view('dashboard::dashboard', [
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