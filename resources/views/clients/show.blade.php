@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<h3 class="block-title">Просмотр деталей клиента</h3>
			<a href="{{ route('clients.edit', ['client' => $client->getKey()]) }}" class="btn btn-primary" role="button">Изменение
				деталей клиента</a>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
						class="si si-arrow-up"></i></button>
			</div>
		</div>
		<div class="block-content block-content-full p4">
			<x-forms.text-input name="name" title="Название клиента" value="{{ $client->name }}" disabled="true" />
			<x-forms.text-input name="inn" title="ИНН клиента" value="{{ $client->inn }}" disabled="true" />
			<x-forms.text-input name="ogrn" title="ОГРН / ОРНИП клиента" value="{{ $client->ogrn }}" disabled="true" />
			<x-forms.textarea-input name="address" title="Адрес" value="{{ $client->address }}" disabled="true" />
			<x-forms.text-input name="phone" type="tel" title="Телефон" value="{{ $client->phone }}" disabled="true" />
			<x-forms.text-input name="url" type="url" title="Электронная почта" value="{{ $client->email }}"
				disabled="true" />
		</div>
	</div>
@endsection
