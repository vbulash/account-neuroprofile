@extends('layouts.page')

@section('body')
	<div class="block block-rounded block-mode-hidden">
		<div class="block-header block-header-default">
			<h3 class="block-title">Просмотр деталей клиента</h3>
			<a href="{{ route('clients.edit', ['client' => $client->getKey()]) }}" class="btn btn-primary" role="button">Изменение
				деталей клиента</a>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
						class="si si-arrow-down"></i></button>
			</div>
		</div>
		<div class="block-content block-content-full p-4">
			<x-forms.text-input name="name" title="Название клиента" value="{{ $client->name }}" disabled="true" />
			<x-forms.text-input name="inn" title="ИНН клиента" value="{{ $client->inn }}" disabled="true" />
			<x-forms.text-input name="ogrn" title="ОГРН / ОРНИП клиента" value="{{ $client->ogrn }}" disabled="true" />
			<x-forms.textarea-input name="address" title="Адрес" value="{{ $client->address }}" disabled="true" />
			<x-forms.text-input name="phone" type="tel" title="Телефон" value="{{ $client->phone }}" disabled="true" />
			<x-forms.text-input name="url" type="url" title="Электронная почта" value="{{ $client->email }}"
				disabled="true" />
		</div>
	</div>

	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<div class="d-flex flex-column justify-content-start align-items-start">
				<h3 class="block-title">Договора клиента</h3>
				<h3 class="block-title"><small>Клик на карточку
						{{ $client->contracts->count() == 1 ? 'договора' : 'одного из договоров' }} ниже для
						работы с ним</small></h3>
			</div>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
						class="si si-arrow-up"></i></button>
			</div>
		</div>

		<div class="block-content block-content-full p-4">
			@foreach ($client->contracts as $contract)
				<div class="col-md-6 col-xl-4">
					<a class="block block-rounded block-link-shadow bg-primary"
						href="{{ route('clients.contracts.show', ['client' => $client->getKey(), 'contract' => $contract->getKey()]) }}">
						<div class="block-content block-content-full d-flex align-items-center justify-content-between p-4">
							<div>
								<i class="fa fa-2x fa-chart-line text-primary-lighter"></i>
							</div>
							<div class="ms-3 text-end">
								<p class="text-white fs-4 fw-medium mb-0">Договор № {{ $contract->number }}</p>
								<p class="text-white fs-5 fw-medium mb-2">лицензий: {{ $contract->license_count }}</p>
								<p class="text-white-75 mb-0">{{ $contract->start->format('d.m.Y') }} &gt;
									{{ $contract->end->format('d.m.Y') }}
								</p>
								<p class="text-white-75 mb-0">{{ $contract->status }}</p>
							</div>
						</div>
					</a>
				</div>
			@endforeach
		</div>
	</div>
@endsection
