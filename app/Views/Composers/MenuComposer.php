<?php

namespace App\Views\Composers;

use App\Http\Controllers\Auth\RoleName;
use App\Models\Client;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MenuComposer {

	protected function genForContract(Client $client, Contract $contract): iterable {
		$result = [
			'type' => 'submenu',
			'title' => $contract->getTitle(),
			'icon' => 'fa fa-lightbulb',
			'pattern' => [
				route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
				route('clients.contracts.edit', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
				route('contracts.licenses.index', ['contract' => $contract->getKey()])
			],
			'items' => [
				[
					'title' => 'Общие сведения',
					'link' => route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
					'pattern' => [
						route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
						route('clients.contracts.edit', ['client' => $client->getKey(), 'contract' => $contract->getKey()]),
					]
				],
				[
					'title' => 'Лицензии',
					'link' => route('contracts.licenses.index', ['contract' => $contract->getKey()]),
					'pattern' => route('contracts.licenses.index', ['contract' => $contract->getKey()]),
				],
				[
					'title' => 'Результаты',
					'link' => '',
					'pattern' => '',
				],
				// [
				//     'title' => 'DataTables',
				//     'route' => 'pages.datatables',
				//     'pattern' => ['pages.datatables'],
				// ],
				// ['title' => 'Slick Slider', 'route' => 'pages.slick', 'pattern' => ['pages.slick']],
				// ['title' => 'Blank', 'route' => 'pages.blank', 'pattern' => ['pages.blank']],
			],
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
		$menu[] = ['type' => 'item', 'title' => 'Главная', 'icon' => 'fa fa-home', 'link' => route('dashboard'), 'pattern' => [route('dashboard')]];
		if (auth()->user()->hasRole(RoleName::ADMIN->value))
			foreach (Client::all()->sortBy('name') as $client)
				$menu = array_merge($menu, $this->genForClient($client));

		$menu[] = ['type' => 'heading', 'title' => 'More'];
		$menu[] = ['type' => 'item', 'title' => 'Landing', 'icon' => 'fa fa-globe', 'link' => route('dashboard'), 'pattern' => route('dashboard')];

		$view->with('menu', $menu);
	}
}