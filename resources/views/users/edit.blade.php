@extends('layouts.page')

@section('body')
	<div class="block block-rounded">
		<div class="block-header block-header-default d-flex flex-column align-items-start">
			<h3 class="block-title">Редактирование анкеты пользователя &laquo;{{ $user->name }}&raquo;</h3>
			<h3 class="block-title mb-2"><small>Символом <span class="required">*</span> отмечены обязательные поля</small></h3>
		</div>
		<div class="block-content block-content-full p-4">
			<form action="{{ route('users.update', ['user' => $user->getKey()]) }}" method="post" enctype="multipart/form-data">
				@method('PUT')
				@csrf
				<x-forms.text-input name="name" title="Фамилия, имя и отчество" value="{{ $user->name }}" required="true" />
				<x-forms.text-input name="email" type="email" title="Электронная почта" value="{{ $user->email }}"
					required="true" />
				<x-forms.textarea-input name="roles" title="Роли пользователя" value="{{ $roles }}" disabled="true" />
				<x-forms.text-input name="password" title="Новый пароль">
					<div class="col-sm-3">
						<button type="button" name="get-password" id="get-password" class="btn btn-primary mb-3">
							Сгенерировать пароль
						</button>
					</div>
				</x-forms.text-input>
				<x-forms.text-input name="password_confirmation" title="Подтверждение пароля" />

				<div class="row">
					<div class="col-sm-3">
						&nbsp;</div>
					<div class="col-sm-5">
						<button type="submit" class="btn btn-primary">Сохранить</button>
						<a class="btn btn-secondary pl-3" href="{{ route('dashboard') }}" role="button">Закрыть</a>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection

@push('js_end')
	<script>
		$(function() {
			$("#get-password").on("click", (event) => {
				event.preventDefault();
				$.post({
					url: "{{ route('api.get.password', ['length' => 10]) }}",
					datatype: "json",
					success: (password) => {
						$("#password").val(password);
					}
				});
			});
		});
	</script>
@endpush
