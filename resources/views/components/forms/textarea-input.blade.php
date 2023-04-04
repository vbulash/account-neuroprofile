<div>
	<div class="row mb-4">
		<label class="col-sm-3 col-form-label" for="{{ $name }}">
			{{ $title }}
			{!! isset($required) && !isset($disabled) ? " <span class='required'>*</span>" : '' !!}
		</label>
		<div class="col-sm-5">
			<textarea class="form-control" id="{{ $name }}" name="{{ $name }}" rows="{{ $rows ?? 5 }}"
			 {{ isset($disabled) && $disabled == 'true' ? 'disabled' : '' }}>{!! $value ?? '' !!}</textarea>
		</div>
		{{ $slot }}
	</div>
</div>
