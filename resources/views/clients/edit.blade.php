@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default d-flex flex-column align-items-start">
			<h3 class="block-title">Изменение деталей клиента</h3>
			<h3 class="block-title mb-2"><small>Символом <span class="required">*</span> отмечены обязательные поля</small></h3>
		</div>
		<div class="block-content block-content-full p-4">
			<form action="{{ route('clients.update', ['client' => $client->getKey()]) }}" method="post"
				enctype="multipart/form-data">
				@method('PUT')
				@csrf
				<x-forms.text-input name="name" title="Название клиента" value="{{ $client->name }}" required="true" />
				<x-forms.text-input name="inn" title="ИНН клиента" value="{{ $client->inn }}" required="true">
					<div class="col-sm-4">
						<p><small>Строгие правила формирования, нельзя ввести произвольное значение. Структуру ИНН можно посмотреть <a
									href="http://www.consultant.ru/document/cons_doc_LAW_134082/947eeb5630c9f58cbc6103f0910440cef8eaccac/"
									target="_blank">здесь</a></small></p>
					</div>
				</x-forms.text-input>
				<x-forms.text-input name="ogrn" title="ОГРН / ОРНИП клиента" value="{{ $client->ogrn }}" required="true">
					<div class="col-sm-4">
						<p><small>Строгие правила формирования, нельзя ввести произвольное значение. Структуру ОГРН / ОГРНИП можно
								посмотреть <a href="https://glavkniga.ru/situations/k505650" target="_blank">здесь</a></small></p>
					</div>
				</x-forms.text-input>
				<x-forms.textarea-input name="address" title="Адрес" value="{{ $client->address }}" required="true" />
				<x-forms.text-input name="phone" type="tel" title="Телефон" value="{{ $client->phone }}" />
				<x-forms.text-input name="email" type="email" title="Электронная почта" value="{{ $client->email }}"
					required="true" />

				<div class="row">
					<div class="col-sm-3">
						&nbsp;</div>
					<div class="col-sm-5">
						<button type="submit" class="btn btn-primary">Сохранить</button>
						<a class="btn btn-secondary pl-3" href="{{ route('clients.show', ['client' => $client->getKey()]) }}"
							role="button">Закрыть</a>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
