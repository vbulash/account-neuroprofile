@extends('layouts.datatables')

@section('header')
	<div class="d-flex align-items-start">
		<div class="d-flex flex-column justify-content-start align-items-start me-5">
			<h3 class="block-title">Список лицензий контракта</h3>
			<h3 class="block-title mb-2"><small>Здесь вы можете отфильтровать лицензии по статусам, исправить проблемы с лицензиями
					из-за сбоев и экспортировать лицензии в формате Excel</small></h3>
			<button type="button" class="btn btn-primary">Экспорт лицензий</button>
		</div>
		<div class="d-flex flex-column justify-content-start align-items-start">
			<label class="form-label" for="filter-status">Показать лицензии со статусом:</label>
			<select name="filter-status" id="filter-status" style="padding: 6px 12px; border-radius: 6px;">
				<option value="0" selected>Все лицензии</option>
				@foreach (App\Models\LicenseStatus::cases() as $status)
					<option value="{{ $status->value }}">{{ App\Models\LicenseStatus::getName($status->value) }}</option>
				@endforeach
			</select>
		</div>
	</div>
@endsection

@section('thead')
	<tr>
		<th style="width: 30px">#</th>
		<th>Персональный ключ</th>
		<th>Статус лицензии</th>
		<th>&nbsp;</th>
	</tr>
@endsection

@section('js_end')
	<script>
		$(function() {
			window.datatable = $('#datatable').DataTable({
				language: {
					"url": "{{ asset('lang/ru/datatables.json') }}",
					searchPlaceholder: 'Персональный ключ...',
				},
				processing: true,
				serverSide: true,
				ajax: {
					url: '{!! route('contracts.licenses.index.data', ['contract' => $contract]) !!}',
					data: (data) => {
						data.status = $('#filter-status').val();
					}
				},
				pageLength: 50,
				responsive: true,
				columns: [{
						data: 'id',
						name: 'id',
						responsivePriority: 1
					},
					{
						data: 'pkey',
						name: 'pkey',
						responsivePriority: 1,
						sortable: false
					},
					{
						data: 'status',
						name: 'status',
						responsivePriority: 2,
						sortable: false
					},
					{
						data: 'action',
						name: 'action',
						sortable: false,
						responsivePriority: 1,
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

			$('#filter-status').change(() => {
				window.datatable.draw();
			});
		});
	</script>
@endsection
