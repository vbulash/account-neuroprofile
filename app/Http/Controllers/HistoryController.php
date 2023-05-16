<?php

namespace App\Http\Controllers;

use App\Http\Controllers\results\BlocksArea;
use App\Http\Controllers\results\BlocksComposer;
use App\Http\Controllers\results\CardComposer;
use App\Mail\ClientMail;
use App\Mail\RespondentMail;
use App\Models\Contract;
use App\Models\History;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Yajra\DataTables\DataTables;

class HistoryController extends Controller {
	public function getData(Request $request, int $contract): JsonResponse {
		$_contract = Contract::findOrFail($contract);
		$fields = $request->fields;
		$query = $_contract->test->history;

		$content = json_decode($_contract->test->content);
		$maildata = [];
		$maildata['show'] = $content->descriptions->show ?? false;
		$maildata['mail'] = $content->descriptions->mail ?? false;
		$maildata['client'] = $content->descriptions->client ?? false;
		$maildata['branding'] = $content->branding ?? false;

		$builder = DataTables::of($query)
			->editColumn('done', fn($history) => $history->done->format('d.m.Y H:i:s'))
			->editColumn('pkey', fn($history) => $history->license->pkey);
		if (isset($fields))
			foreach ($fields as $name => $itle)
				$builder
					->addColumn($name, function ($history) use ($fields, $name) {
						$values = $history->getCardValues($fields);
						return $values[$name];
					});
		$builder = $builder
			->addColumn('action', function ($history) use ($contract, $maildata) {
				$showRoute = route('contracts.history.show', [
					'contract' => $contract,
					'history' => $history->getKey()
				]);
				$recipientFunc = sprintf("mailRecipient(%d, '%s')",
					$history->getKey(), base64_encode(json_encode($maildata))
				);
				$clientFunc = sprintf("mailClient(%d, '%s')",
					$history->getKey(), base64_encode(json_encode($maildata))
				);
				$items = [];
				$items[] = [
					'type' => 'item',
					'link' => $showRoute, 'icon' => 'fas fa-eye', 'title' => 'Просмотр'
				];

				if ($maildata['show'] != false || $maildata['mail'] != false || $maildata['client'] != false)
					$items[] = ['type' => 'divider'];

				if ($maildata['show'] != false)
					$items[] = [
						'type' => 'item',
						'click' => "javascript:void(0)", 'icon' => 'fas fa-eye', 'title' => 'Просмотр результатов тестирования'
					];
				if ($maildata['mail'] != false)
					$items[] = [
						'type' => 'item',
						'click' => $recipientFunc, 'icon' => 'fas fa-user', 'title' => 'Повтор письма респонденту'
					];

				if ($maildata['client'] != false)
					$items[] = [
						'type' => 'item',
						'click' => $clientFunc, 'icon' => 'fas fa-building', 'title' => 'Повтор письма клиенту'
					];

				return createDropdown('Действия', $items);
			})
			->make(true);

		return $builder;
	}

	public function index(int $contract) {
		$_contract = Contract::findOrFail($contract);
		$heading = sprintf("Результаты тестирования по договору № %s клиента &laquo;%s&raquo;",
			$_contract->number, $_contract->client->getTitle()
		);
		// $count = $_contract->test->history->count();
		return view('history.index', [
			'heading' => $heading,
			'contract' => $_contract,
			'fields' => $_contract->test->getCardFields()
		]);
	}

	public function export(int $contract) {
		$_contract = Contract::findOrFail($contract);
		$fields = $_contract->test->getCardFields();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'Дата и время завершения');
		$sheet->setCellValue('B1', 'Персональный ключ');
		$column = 3;
		foreach ($fields as $key => $title) {
			$letter = Coordinate::stringFromColumnIndex($column++);
			$sheet->setCellValue($letter . '1', 'Анкета: ' . $title);
		}
		for ($row = 1; $row <= 1; $row++)
			for ($column = 1; $column <= count($fields) + 2; $column++) {
				$letter = Coordinate::stringFromColumnIndex($column);
				$style = $sheet->getStyle($letter . $row);
				$style->getFont()->setBold(true);
				// $style->getFill()->setFillType(Fill::);
				$style->getFill()->getStartColor()->setRGB('B0B3B2');
			}
		$sheet->freezePane('A2');

		$row = 1;
		foreach ($_contract->test->history as $history) {
			$values = $history->getCardValues($fields);
			$sheet->setCellValue('A' . (++$row), $history->done->format('d.m.Y H:i:s'));
			$sheet->setCellValue('B' . $row, $history->license->pkey);
			$column = 3;
			foreach ($values as $key => $value) {
				$letter = Coordinate::stringFromColumnIndex($column++);
				$sheet->setCellValue($letter . $row, $value);
			}
		}

		$tmpsheet = 'tmp/' . Str::uuid() . '.xlsx';
		$writer = new WriterXlsx($spreadsheet);
		try {
			Storage::makeDirectory('tmp');
			$writer->save(Storage::path($tmpsheet));
			// Экспорт истории тестирования - Название клиента - Номер договора
			$tempFile = sprintf("Экспорт истории тестирования - %s - %s", $_contract->client->getTitle(), $_contract->number);
			$tempFile = str_replace([
				' ',
				'.',
				',',
				'\"',
				'\'',
				'\\',
				'/',
				'«',
				'»'
			], '_', $tempFile);
			return response()
				->download(Storage::path($tmpsheet), $tempFile . '.xlsx')
				->deleteFileAfterSend();
		} catch (\Exception $e) {
		}
		return true;
	}

	public function show(int $contract, int $history) {
		$_contract = Contract::findOrFail($contract);
		$_history = History::findOrFail($history);
		$heading = sprintf("Результаты тестирования по договору № %s клиента &laquo;%s&raquo;",
			$_contract->number, $_contract->client->getTitle()
		);
		$fields = $_contract->test->getCardFields();
		$values = $_history->getCardValues($fields);

		return view('history.show', [
			'heading' => $heading,
			'contract' => $_contract,
			'history' => $_history,
			'fields' => $fields,
			'values' => $values
		]);
	}

	public function mailRecipient(Request $request) {
		$history = $request->history;
		$maildata = json_decode(base64_decode($request->maildata));

		$_history = History::findOrFail($history);

		$card = (new CardComposer($_history))->getCard();
		$composer = new BlocksComposer($_history);
		$profile = $composer->getProfile(BlocksArea::MAIL);
		$blocks = $composer->getBlocks($profile);

		$recipient = new Address($card['Электронная почта'], join(' ', [$card['Фамилия'] ?? null, $card['Имя'] ?? null, $card['Отчество'] ?? null]));
		$copy = new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

		$branding = null;
		if (isset($maildata) && is_object($maildata) && isset($maildata->branding) && !is_bool($maildata->branding))
			$branding = $maildata->branding;
		$testResult = new RespondentMail($_history, $blocks, $card, $profile, $branding);
		try {
			Mail::to($recipient)
				->cc($copy)
				->send($testResult);
		} catch (\Exception $exc) {
			session()->put('error', "Ошибка отправки письма с результатами тестирования:<br/>" .
				$exc->getMessage());
		}
	}

	public function mailClient(Request $request) {
		$history = $request->history;
		$maildata = json_decode(base64_decode($request->maildata));

		$_history = History::findOrFail($history);

		$card = (new CardComposer($_history))->getCard();
		$composer = new BlocksComposer($_history);
		$profile = $composer->getProfile(BlocksArea::CLIENT);
		$blocks = $composer->getBlocks($profile);

		$recipient = new Address(
			$_history->test->contract->email ?? $_history->test->contract->client->email,
			$_history->test->contract->client->name
		);
		$copy = new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

		$branding = null;
		if (isset($maildata) && is_object($maildata) && isset($maildata->branding) && !is_bool($maildata->branding))
			$branding = $maildata->branding;
		$testResult = new ClientMail($_history, $blocks, $card, $profile, $branding);
		try {
			Mail::to($recipient)
				->cc($copy)
				->send($testResult);
		} catch (\Exception $exc) {
			session()->put('error', "Ошибка отправки письма с результатами тестирования:<br/>" .
				$exc->getMessage());
		}



	}
}