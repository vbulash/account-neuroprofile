<div>
	<div class="row mb-4">
		<label class="col-sm-3 col-form-label" for="{{ $name }}">
			{{ $title }}
			{!! isset($required) && !isset($disabled) ? " <span class='required'>*</span>" : '' !!}
		</label>
		<div class="col-sm-5">
			<input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}" autocomplete="off"
				value="{{ isset($value) ? $value : '' }}" {{ isset($disabled) ? 'disabled' : '' }} />
		</div>
		{{ $slot }}
	</div>
</div>
