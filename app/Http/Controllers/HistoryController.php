<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller {
	public function getData(int $contract): JsonResponse {
		$_contract = Contract::findOrFail($contract);
		$query = $_contract->test->history;

		return DataTables::of($query)
			->editColumn('done', fn($history) => $history->done->format('d.m.Y H:i:s'))
			->editColumn('pkey', fn($history) => $history->license->pkey)
			->addColumn('action', function ($license) use ($contract) {
				$items = [];
				$items[] = [
					'type' => 'item',
					'link' => route('dashboard'), 'icon' => 'fas fa-tools', 'title' => 'Исправить'
				];
				return createDropdown('Действия', $items);
			})
			->make(true);
	}

	public function index(int $contract) {
		$_contract = Contract::findOrFail($contract);
		$heading = sprintf("Результаты тестирования по договору № %s клиента &laquo;%s&raquo;",
			$_contract->number, $_contract->client->getTitle()
		);
		// $count = $_contract->test->history->count();
		return view('history.index', [
			'heading' => $heading,
			'contract' => $_contract
		]);
	}
}