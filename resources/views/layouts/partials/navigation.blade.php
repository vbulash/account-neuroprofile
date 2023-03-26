<ul class="nav-main">
	@foreach ($menu as $item)
		@switch($item['type'])
			@case('heading')
				<li class="nav-main-heading">{!! $item['title'] !!}</li>
			@break

			@case('item')
				<li class="nav-main-item">
					<a class="nav-main-link{{ request()->routeIs($item['pattern']) ? ' active' : '' }}" href="{{ $item['link'] }}">
						<i class="nav-main-link-icon {{ $item['icon'] }}"></i>
						<span class="nav-main-link-name">{!! $item['title'] !!}</span>
					</a>
				</li>
			@break

			@case('submenu')
				<li class="nav-main-item{{ request()->routeIs($item['pattern']) ? ' open' : '' }}">
					<a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
						href="#">
						<i class="nav-main-link-icon {{ $item['icon'] }}"></i>
						<span class="nav-main-link-name">{!! $item['title'] !!}</span>
					</a>
					<ul class="nav-main-submenu">
						@foreach ($item['items'] as $subitem)
							<li class="nav-main-item">
								<a class="nav-main-link{{ request()->routeIs($subitem['pattern']) ? ' open' : '' }}"
									href="{{ $subitem['link'] }}">
									<span class="nav-main-link-name">{!! $subitem['title'] !!}</span>
								</a>
							</li>
						@endforeach
					</ul>
				</li>
			@break

			@default
		@endswitch
	@endforeach
</ul>
