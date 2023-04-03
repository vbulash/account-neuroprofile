@if (isset($card['Пол']) || isset($card['Имя']) || isset($card['Фамилия']))
	@php
		if (!isset($card['Пол'])) {
		    $card['Пол'] = '';
		}
		if (!isset($card['Имя'])) {
		    $card['Имя'] = '';
		}
		if (!isset($card['Фамилия'])) {
		    $card['Фамилия'] = '';
		}
		
		$greeting = match ($card['Пол']) {
		    'М' => 'Уважаемый',
		    'Ж' => 'Уважаемая',
		    default => '',
		};
	@endphp
	<h1>{{ $greeting }} {{ $card['Имя'] . ' ' . $card['Фамилия'] }}</h1>
	<p>Респондент прошел тестирование по тесту &laquo;{{ $history->test->name }}&raquo;</p>
@endif

@if ($history->test->options & (\App\Models\TestOptions::AUTH_FULL->value | \App\Models\TestOptions::AUTH_MIX->value))
	<h1>Перед прохождением респондент ввел анкетные данные:</h1>
	<ul>
		@foreach ($card as $key => $value)
			@if (!$value)
				@continue
			@endif
			<li>{{ $key }} : {{ $value }}</li>
		@endforeach
	</ul>
@endif

<h1>
	Результат тестирования респондента:
</h1>
<h4>Название нейропрофиля: {{ $profile->name }}</h4>

@forelse($blocks  as $block)
	@if ($block->type != \App\Models\BlockType::Image->value)
		<h2>{{ $block->name }}</h2>
	@else
		@php
			$image = env('MEDIA_URL') . '/uploads/' . $block->full;
		@endphp
	@endif

	@switch($block->type)
		@case(\App\Models\BlockType::Text->value)
			<div style="margin-left: 20px;">{!! $block->full !!}</div>
		@break

		@case(\App\Models\BlockType::Image->value)
			<div style="margin-left: 20px;">
				<img src="{{ $image }}" class="img-fluid"
					alt="Разрешите загрузку картинок, чтобы увидеть приложенную или приложенные к данному письму" />
			</div>
		@break

		@default
	@endswitch
	@empty
		<h2>Настройка теста не завершена.<br />
			Нет блоков описаний, соответствующих коду нейропрофиля &laquo;{{ $profile->code }}&raquo;</h2>
	@endforelse

	<div style="margin-top: 40px;">
		@if (isset($branding) && isset($branding->signature))
			{!! $branding->signature !!}
		@else
			С уважением,<br />
			<a href="{{ env('BRAND_URL') }}" target="_blank">{{ env('BRAND_NAME') }}</a>
		@endif
	</div>
