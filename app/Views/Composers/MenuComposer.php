<?php

namespace App\Views\Composers;

use App\Http\Controllers\Auth\RoleName;
use App\Models\Client;
use App\Models\Contract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer {

	protected function genForContract(Client $client, Contract $contract): iterable {
		$items = [];
		$items[] = [
			'title' => 'Общие сведения',
			'link' => route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
			'pattern' => [
				route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
				route('clients.contracts.edit', ['client' => $client->getKey(), 'contract' => $contract->getKey()])
			]
		];
		$items[] = [
			'title' => 'Лицензии',
			'link' => route('contracts.licenses.index', ['contract' => $contract->getKey()]),
			'pattern' => route('contracts.licenses.index', ['contract' => $contract->getKey()]),
		];
		if ($contract->test->history->count() > 0)
			$items[] = [
				'title' => 'Результаты',
				'link' => route('contracts.history.index', ['contract' => $contract->getKey()]),
				'pattern' => [
					route('contracts.history.index', ['contract' => $contract->getKey()]),
				],
			];
		$result = [
			'type' => 'submenu',
			'title' => $contract->getTitle(),
			'icon' => 'fa fa-lightbulb',
			'pattern' => [
				route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
				route('clients.contracts.edit', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
				route('contracts.licenses.index', ['contract' => $contract->getKey()]),
				route('contracts.history.index', ['contract' => $contract->getKey()])
			],
			'items' => $items,
			// [
			//     'title' => 'DataTables',
			//     'route' => 'pages.datatables',
			//     'pattern' => ['pages.datatables'],
			// ],
			// ['title' => 'Slick Slider', 'route' => 'pages.slick', 'pattern' => ['pages.slick']],
			// ['title' => 'Blank', 'route' => 'pages.blank', 'pattern' => ['pages.blank']
		];
		return $result;
	}
	protected function genForClient(Client $client): iterable {
		$result = [];
		$result[] = ['type' => 'heading', 'title' => $client->getTitle()];
		// Route::get('/clients/{client}', [ClientController::class, 'show'])->name(('clients.show'));
		$result[] = [
			'type' => 'item',
			'title' => 'Общие сведения',
			'icon' => 'fas fa-building',
			'link' => route('clients.show', ['client' => $client->getKey()]),
			'pattern' => [
				route('clients.show', ['client' => $client->getKey()]),
				route('clients.edit', ['client' => $client->getKey()]),
			]
		];
		foreach ($client->contracts as $contract)
			$result[] = $this->genForContract($client, $contract);

		return $result;
	}

	public function compose(View $view) {
		if (!Auth::check())
			return;
		$menu = [];
		if (auth()->user()->hasRole(RoleName::ADMIN->value)) {
			$menu[] = ['type' => 'item', 'title' => 'Главная', 'icon' => 'fa fa-home', 'link' => route('dashboard'), 'pattern' => [route('dashboard')]];
			foreach (Client::all()->sortBy('name') as $client)
				$menu = array_merge($menu, $this->genForClient($client));
		} else {
			$allowed = new Collection();
			foreach (Client::all()->sortBy('name') as $client)
				if (auth()->user()->hasPermissionTo('clients.show.' . $client->getKey()))
					$allowed->add($client);

			if ($allowed->count() > 1)
				$menu[] = ['type' => 'item', 'title' => 'Главная', 'icon' => 'fa fa-home', 'link' => route('dashboard'), 'pattern' => [route('dashboard')]];

			$allowed->map(function ($client) use (&$menu) {
				$menu = array_merge($menu, $this->genForClient($client));
			});
		}

		$view->with('menu', $menu);
	}
}