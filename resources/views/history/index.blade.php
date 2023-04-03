@extends('layouts.datatables')

@section('header')
	<div class="d-flex align-items-start">
		<div class="d-flex flex-column justify-content-start align-items-start me-5">
			<h3 class="block-title">История тестирования</h3>
			<h3 class="block-title mb-2"><small>Здесь вы можете исследовать историю тестирования и экспортировать её</small></h3>
			<form action="{{ route('contracts.history.export', ['contract' => $contract]) }}" method="post" id="export">
				@csrf
				<button type="submit" class="btn btn-primary">Экспорт истории тестирования</button>
			</form>
		</div>
	</div>
@endsection

@section('thead')
	<tr>
		<th style="width: 30px">#</th>
		<th>Дата и время завершения</th>
		<th>Персональный ключ</th>
		@foreach ($fields as $name => $title)
			<th>Анкета: {{ $title }}</th>
		@endforeach
		<th>&nbsp;</th>
	</tr>
@endsection

@push('js_end')
	<script>
		function mailRecipient(history, maildata) {
			$.ajax({
				method: 'POST',
				contentType: 'application/x-www-form-urlencoded',
				url: "{{ route('contracts.history.mail.recipient') }}",
				data: {
					history: history,
					maildata: maildata
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: () => {
					Dashmix.helpers('jq-notify', {
						from: 'bottom',
						type: 'info',
						icon: 'fa fa-info-circle me-2',
						message: 'Отправка повторного письма респонденту..'
					});
				},
				success: () => {
					// statistics();
					// window.datatable.ajax.reload();
					// Dashmix.helpers('jq-notify');
				}
			});
		}

		function mailClient(history, maildata) {
			$.ajax({
				method: 'POST',
				contentType: 'application/x-www-form-urlencoded',
				url: "{{ route('contracts.history.mail.client') }}",
				data: {
					history: history,
					maildata: maildata
				},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: () => {
					Dashmix.helpers('jq-notify', {
						from: 'bottom',
						type: 'info',
						icon: 'fa fa-info-circle me-2',
						message: 'Отправка повторного письма клиенту..'
					});
				},
				success: () => {
					// statistics();
					// window.datatable.ajax.reload();
					// Dashmix.helpers('jq-notify');
				}
			});
		}

		$(function() {
			window.datatable = $('#datatable').DataTable({
				language: {
					"url": "{{ asset('lang/ru/datatables.json', true) }}",
					searchPlaceholder: 'Поиск...',
				},
				processing: true,
				serverSide: true,
				ajax: '{!! route('contracts.history.index.data', [
				    'contract' => $contract,
				    'fields' => $fields,
				]) !!}',
				pageLength: 100,
				order: [
					[0, 'desc']
				],
				columns: [{
						data: 'id',
						name: 'id',
						responsivePriority: 1,
					},
					{
						data: 'done',
						name: 'done',
						responsivePriority: 1,
						sortable: false
					},
					{
						data: 'pkey',
						name: 'pkey',
						responsivePriority: 2,
						sortable: false
					},
					@foreach ($fields as $name => $title)
						{
							data: '{{ $name }}',
							name: '{{ $name }}',
							responsivePriority: 3,
							sortable: false
						},
					@endforeach {
						data: 'action',
						name: 'action',
						sortable: false,
						responsivePriority: 1,
						exporttable: false,
						className: 'no-wrap dt-actions'
					}
				]
			});

			window.datatable.on('draw', function() {
				$('.dropdown-toggle.actions').on('shown.bs.dropdown', (event) => {
					const menu = event.target.parentElement.querySelector('.dropdown-menu');
					let parent = menu.closest('.dataTables_wrapper');
					const parentRect = parent.getBoundingClientRect();
					parentRect.top = Math.abs(parentRect.top);
					const menuRect = menu.getBoundingClientRect();
					const buttonRect = event.target.getBoundingClientRect();
					const menuTop = Math.abs(buttonRect.top) + buttonRect.height + 4;
					if (menuTop + menuRect.height > parentRect.top + parentRect.height) {
						const clientHeight = parentRect.height + menuTop + menuRect.height - (
							parentRect.top + parentRect.height);
						parent.style.height = clientHeight.toString() + 'px';
					}
				});
			});

			$('#export').submit(() => {
				Dashmix.helpers('jq-notify', {
					from: 'bottom',
					type: 'info',
					icon: 'fa fa-info-circle me-2',
					message: 'Создание файла экспорта...'
				});
			});
		});
	</script>
@endpush
