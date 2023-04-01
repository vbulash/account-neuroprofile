@extends('layouts.page')

@section('body')
	<div class="block block-rounded block-mode-hidden">
		<div class="block-header block-header-default">
			<h3 class="block-title">Просмотр деталей договора</h3>
			<a
				href="{{ route('clients.contracts.edit', ['client' => $contract->client->getKey(), 'contract' => $contract->getKey()]) }}"
				class="btn btn-primary" role="button">Изменение деталей договора</a>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
						class="si si-arrow-down"></i></button>
			</div>
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

	<div class="block block-rounded">
		<div class="block-header block-header-default">
			<div class="d-flex flex-column justify-content-start align-items-start">
				<h3 class="block-title">Статистика лицензий договора</h3>
				<h3 class="block-title"><small>Всего лицензий: {{ $contract->license_count }}</small></h3>
			</div>
			<div class="block-options">
				<button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"><i
						class="si si-arrow-up"></i></button>
			</div>
		</div>
		<div class="block-content block-content-full p-4">
			<div class="row" id="statistics">
			</div>
			<div class="row">
				<div>
					<a href="{{ route('contracts.licenses.index', ['contract' => $contract->getKey()]) }}"
						class="btn btn-primary">Работа
						с лицензиями договора <i class="fas fa-chevron-right"></i></a>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('js_end')
	<script>
		function statistics() {
			$.ajax({
				method: 'POST',
				url: "{{ route('contracts.licenses.info', ['contract' => $contract]) }}",
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				success: (data) => {
					let background = '';
					let icon = '';
					let iconColor = '';
					let titleColor = '';
					let subTitleColor = '';
					let infoRows = '';

					for (let index in data) {
						switch (data[index].name) {
							case "{{ App\Models\LicenseStatus::getName(App\Models\LicenseStatus::FREE->value) }}":
								background = 'bg-primary';
								icon = 'fa-bolt';
								iconColor = 'text-white';
								titleColor = 'text-white';
								subTitleColor = 'text-white-75';
								break;
							case "{{ App\Models\LicenseStatus::getName(App\Models\LicenseStatus::USING->value) }}":
							case "{{ App\Models\LicenseStatus::getName(App\Models\LicenseStatus::BROKEN->value) }}":
								background = 'bg-danger';
								icon = 'fa-ban';
								iconColor = 'text-white';
								titleColor = 'text-white';
								subTitleColor = 'text-white-75';
								break;
							case "{{ App\Models\LicenseStatus::getName(App\Models\LicenseStatus::USED->value) }}":
								background = 'bg-success';
								icon = 'fa-check';
								iconColor = 'text-white';
								titleColor = 'text-white';
								subTitleColor = 'text-white-75';
								break;
							default:
								background = 'bg-success';
								icon = 'fa-bolt';
								iconColor = 'text-white';
								titleColor = 'text-white';
								subTitleColor = 'text-white-75';
						}
						infoRows = infoRows + `
							<div class="col-md-6 col-xl-3">
								<div class="block block-rounded block-link-shadow ${background}" style="opacity: 0.9;">
									<div class="block-content block-content-full d-flex align-items-center justify-content-between">
										<div>
											<i class="fa fa-2x ${icon} ${iconColor}"></i>
										</div>
										<div class="ms-3 text-end">
											<p class="${titleColor} fs-3 fw-medium mb-0">${data[index].count}</p>
											<p class="${subTitleColor} mb-0">${data[index].name}</p>
										</div>
									</div>
								</div>
							</div>`;
					}
					$('#statistics').html(infoRows);
				}
			});
		}

		$(function() {
			statistics();
		});
	</script>
@endpush
