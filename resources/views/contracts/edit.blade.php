@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default d-flex flex-column align-items-start">
			<h3 class="block-title">Изменение деталей договора</h3>
			<h3 class="block-title mb-2"><small>Символом <span class="required">*</span> отмечены обязательные поля</small></h3>
		</div>
		<div class="block-content block-content-full p4">
			<form
				action="{{ route('clients.contracts.update', ['client' => $contract->client->getKey(), 'contract' => $contract->getKey()]) }}"
				method="post" enctype="multipart/form-data">
				@method('PUT')
				@csrf
				<x-forms.text-input name="number" title="Номер договора" value="{{ $contract->number }}" required="true" />
				<x-forms.date-input name="start" title="Дата начала договора" value="{{ $contract->start->format('d.m.Y') }}"
					required="true" />
				<x-forms.date-input name="end" title="Дата завершения договора" value="{{ $contract->end->format('d.m.Y') }}"
					required="true" />
				<x-forms.text-input name="status" title="Статус договора" value="{{ $contract->status }}" disabled="true">
					<div class="col-sm-4">
						<p><small>Изменяется автоматически в зависимости от дат договора и статуса лицензий</small></p>
					</div>
				</x-forms.text-input>
				<x-forms.text-input name="invoice" title="Номер оплаченного счёта" value="{{ $contract->invoice }}"
					required="true" />
				<x-forms.text-input name="license_count" title="Количество лицензий договора" value="{{ $contract->license_count }}"
					disabled="true">
					<div class="col-sm-4">
						<p><small>Количество лицензий может быть изменено только в бОльшую сторону (довыпуск лицензий).
								Данная операция выполняется в &laquo;Платформе нейропрофилирования&raquo; при наличии соответствующих
								прав.</small></p>
					</div>
				</x-forms.text-input>
				<x-forms.text-input name="email" type="email" title="Электронная почта договора"
					value="{{ $contract->email }}" />
				<x-forms.text-input name="url" type="url" title="URL страницы сайта из договора" value="{{ $contract->url }}"
					required="true" />
				<x-forms.text-input name="mkey" title="Мастер-ключ договора" value="{{ $contract->mkey }}" disabled="true" />

				<div class="row">
					<div class="col-sm-3">
						&nbsp;</div>
					<div class="col-sm-5">
						<button type="submit" class="btn btn-primary">Сохранить</button>
						<a class="btn btn-secondary pl-3"
							href="{{ route('clients.contracts.show', ['client' => $contract->client->getKey(), 'contract' => $contract->getKey()]) }}"
							role="button">Закрыть</a>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection
