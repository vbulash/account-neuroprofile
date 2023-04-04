@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default d-flex flex-column align-items-start">
			<h3 class="block-title">История тестирования от {{ $history->done->format('d.m.Y H:i:s') }}</h3>
		</div>
		<div class="block-content block-content-full p-4">
			@if (count($fields) > 0)
				<div class="row">
					<p><strong>В ходе тестирования собрана дополнительная информация о респонденте:</strong></p>
				</div>
				@foreach ($fields as $name => $title)
					<x-forms.text-input name="{{ $name }}" title="{{ $title }}" value="{{ $values[$name] }}"
						disabled="true" />
				@endforeach
			@endif
			<div class="row">
				<p><strong>Важная информация по данной записи истории тестирования:</strong></p>
			</div>
			<x-forms.text-input name="done" title="Дата и время тестирования"
				value="{{ $history->done->format('d.m.Y H:i:s') }}" disabled="true" />
			<x-forms.text-input name="pkey" title="Персональный ключ" value="{{ $history->license->pkey }}" disabled="true" />
			@can('test.code')
				<x-forms.text-input name="code" title="Вычисленный код результата" value="{{ $history->code }}" disabled="true" />
			@endcan

			<div class="row">
				<div class="col-sm-3">
					&nbsp;</div>
				<div class="col-sm-5">
					<a class="btn btn-primary pl-3" href="{{ route('contracts.history.index', ['contract' => $contract->getKey()]) }}"
						role="button">Закрыть</a>
				</div>
			</div>
		</div>
	</div>
@endsection
