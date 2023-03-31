@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<h3 class="block-title">Просмотр деталей договора</h3>
			<a
				href="{{ route('clients.contracts.edit', ['client' => $contract->client->getKey(), 'contract' => $contract->getKey()]) }}"
				class="btn btn-primary" role="button">Изменение деталей договора</a>
		</div>
		<div class="block-content block-content-full p4">
			<x-forms.text-input name="number" title="Номер договора" value="{{ $contract->number }}" disabled="true" />
			<x-forms.date-input name="start" title="Дата начала договора" value="{{ $contract->start->format('d.m.Y') }}"
				disabled="true" />
			<x-forms.date-input name="end" title="Дата завершения договора" value="{{ $contract->end->format('d.m.Y') }}"
				disabled="true" />
			<x-forms.text-input name="status" title="Статус договора" value="{{ $contract->status }}" disabled="true" />
			<x-forms.text-input name="invoice" title="Номер оплаченного счёта" value="{{ $contract->invoice }}" disabled="true" />
			<x-forms.text-input name="license_count" title="Количество лицензий договора" value="{{ $contract->license_count }}"
				disabled="true">
				<div class="col-sm-4">
					<a href="{{ route('contracts.licenses.index', ['contract' => $contract->getKey()]) }}"
						class="btn btn-primary">Работа
						с лицензиями договора <i class="fas fa-chevron-right"></i></a>
				</div>
			</x-forms.text-input>
			<x-forms.text-input name="email" title="Электронная почта договора" value="{{ $contract->email }}"
				disabled="true" />
			<x-forms.text-input name="url" title="URL страницы сайта из договора" value="{{ $contract->url }}"
				disabled="true" />
			<x-forms.text-input name="mkey" title="Мастер-ключ договора" value="{{ $contract->mkey }}" disabled="true" />
		</div>
	</div>
@endsection
