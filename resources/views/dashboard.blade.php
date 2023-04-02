@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<div class="d-flex flex-column justify-content-start align-items-start">
				<h3 class="block-title">Клиенты</h3>
				<h3 class="block-title"><small>Клик на карточку
						{{ $clients->count() == 1 ? 'клиента' : 'одного из клиентов' }} ниже для
						работы с ним</small></h3>
			</div>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
						class="si si-arrow-up"></i></button>
			</div>
		</div>

		<div class="block-content block-content-full p-4 row">
			@foreach ($clients as $client)
				<div class="col-md-6 col-xl-4">
					<a class="block block-rounded block-link-shadow bg-primary"
						href="{{ route('clients.show', ['client' => $client->getKey()]) }}">
						<div class="block-content block-content-full d-flex align-items-center justify-content-between p-4">
							<div>
								<i class="fa fa-2x fa-building text-primary-lighter"></i>
							</div>
							<div class="ms-3 text-end">
								<p class="text-white fs-4 fw-medium mb-0">Клиент &laquo;{{ $client->getTitle() }}</p>
								<p class="text-white-75 mb-0">договоров с клиентом: {{ $client->contracts->count() }}</p>
							</div>
						</div>
					</a>
				</div>
			@endforeach
		</div>
	</div>
@endsection
