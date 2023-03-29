<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

	<title>{{ env('APP_NAME') }}</title>

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="description"
		content="Dashmix - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
	<meta name="author" content="pixelcave">
	<meta name="robots" content="noindex, nofollow">

	<!-- Icons -->
	<link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png', true) }}">
	<link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png', true) }}">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png', true) }}">

	<!-- Modules -->
	@yield('css')
	{{-- @vite(['resources/sass/main.scss', 'resources/js/dashmix/app.js']) --}}

	<!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
	@vite(['resources/sass/main.scss', 'resources/sass/dashmix/themes/xsmooth.scss', 'resources/js/dashmix/app.js'])
	@yield('js')
</head>

<body>
	<!-- Page Container -->
	<!--
				Available classes for #page-container:

				SIDEBAR & SIDE OVERLAY

						'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
						'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
						'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
						'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
						'sidebar-dark'                              Dark themed sidebar

						'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
						'side-overlay-o'                            Visible Side Overlay by default

						'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

						'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

				HEADER

						''                                          Static Header if no class is added
						'page-header-fixed'                         Fixed Header


				FOOTER

						''                                          Static Footer if no class is added
						'page-footer-fixed'                         Fixed Footer (please have in mind that the footer has a specific height when is fixed)

				HEADER STYLE

						''                                          Classic Header style if no class is added
						'page-header-dark'                          Dark themed Header
						'page-header-glass'                         Light themed Header with transparency by default
																																																		(absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
						'page-header-glass page-header-dark'         Dark themed Header with transparency by default
																																																		(absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

				MAIN CONTENT LAYOUT

						''                                          Full width Main Content if no class is added
						'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
						'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)

				DARK MODE

						'sidebar-dark page-header-dark dark-mode'   Enable dark mode (light sidebar/header is not supported with dark mode)
		-->
	<div id="page-container"
		class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow page-header-dark">
		<!-- Side Overlay-->
		{{-- <aside id="side-overlay">
			<!-- Side Header -->
			<div class="bg-image"
				style="background-image: url('{{ asset('media/various/bg_side_overlay_header.jpg', true) }}');">
				<div class="bg-primary-op">
					<div class="content-header">
						<!-- User Avatar -->
						<a class="img-link me-1" href="javascript:void(0)">
							<img class="img-avatar img-avatar48" src="{{ asset('media/avatars/avatar10.jpg', true) }}" alt="">
						</a>
						<!-- END User Avatar -->

						<!-- User Info -->
						<div class="ms-2">
							<a class="text-white fw-semibold" href="javascript:void(0)">George Taylor</a>
							<div class="text-white-75 fs-sm">Full Stack Developer</div>
						</div>
						<!-- END User Info -->

						<!-- Close Side Overlay -->
						<!-- Layout API, functionality initialized in Template._uiApiLayout() -->
						<a class="ms-auto text-white" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
							<i class="fa fa-times-circle"></i>
						</a>
						<!-- END Close Side Overlay -->
					</div>
				</div>
			</div>
			<!-- END Side Header -->

			<!-- Side Content -->
			<div class="content-side">
				<div class="block pull-x mb-0">
					<!-- Sidebar -->
					<div class="block-content block-content-sm block-content-full bg-body">
						<span class="text-uppercase fs-sm fw-bold">Sidebar</span>
					</div>
					<div class="block-content block-content-full">
						<div class="row g-sm text-center">
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="sidebar_style_dark"
									href="javascript:void(0)">Dark</a>
							</div>
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
									data-action="sidebar_style_light" href="javascript:void(0)">Light</a>
							</div>
						</div>
					</div>
					<!-- END Sidebar -->

					<!-- Header -->
					<div class="block-content block-content-sm block-content-full bg-body">
						<span class="text-uppercase fs-sm fw-bold">Header</span>
					</div>
					<div class="block-content block-content-full">
						<div class="row g-sm text-center mb-2">
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_style_dark"
									href="javascript:void(0)">Dark</a>
							</div>
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_style_light"
									href="javascript:void(0)">Light</a>
							</div>
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_mode_fixed"
									href="javascript:void(0)">Fixed</a>
							</div>
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout" data-action="header_mode_static"
									href="javascript:void(0)">Static</a>
							</div>
						</div>
					</div>
					<!-- END Header -->

					<!-- Content -->
					<div class="block-content block-content-sm block-content-full bg-body">
						<span class="text-uppercase fs-sm fw-bold">Content</span>
					</div>
					<div class="block-content block-content-full">
						<div class="row g-sm text-center">
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
									data-action="content_layout_boxed" href="javascript:void(0)">Boxed</a>
							</div>
							<div class="col-6 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
									data-action="content_layout_narrow" href="javascript:void(0)">Narrow</a>
							</div>
							<div class="col-12 mb-1">
								<a class="d-block py-3 bg-body-dark fw-semibold text-dark" data-toggle="layout"
									data-action="content_layout_full_width" href="javascript:void(0)">Full Width</a>
							</div>
						</div>
					</div>
					<!-- END Content -->
				</div>
				<div class="block pull-x mb-0">
					<!-- Content -->
					<div class="block-content block-content-sm block-content-full bg-body">
						<span class="text-uppercase fs-sm fw-bold">Heading</span>
					</div>
					<div class="block-content">
						<p>
							Content..
						</p>
					</div>
					<!-- END Content -->
				</div>
			</div>
			<!-- END Side Content -->
		</aside> --}}
		<!-- END Side Overlay -->

		<!-- Sidebar -->
		<!--
						Sidebar Mini Mode - Display Helper classes

						Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
						Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
										If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

						Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
						Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
						Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
				-->
		<nav id="sidebar" aria-label="Main Navigation">
			<!-- Side Header -->
			<div class="bg-header-dark">
				<div class="content-header bg-white-5">
					<!-- Logo -->
					<a class="fw-semibold text-white tracking-wide" href="/">
						{{ env('APP_NAME') }}
						{{-- <span class="smini-visible">
							D<span class="opacity-75">x</span>
						</span>
						<span class="smini-hidden">
							Dash<span class="opacity-75">mix</span>
						</span> --}}
					</a>
					<!-- END Logo -->
				</div>
			</div>
			<!-- END Side Header -->

			<!-- Sidebar Scrolling -->
			<div class="js-sidebar-scroll">
				<!-- Side Navigation -->
				<div class="content-side content-side-full">
					@include('layouts.partials.navigation')
				</div>
				<!-- END Side Navigation -->
			</div>
			<!-- END Sidebar Scrolling -->
		</nav>
		<!-- END Sidebar -->

		<!-- Header -->
		<header id="page-header">
			<!-- Header Content -->
			<div class="content-header">
				<!-- Left Section -->
				<div class="space-x-1">
					<!-- Toggle Sidebar -->
					<!-- Layout API, functionality initialized in Template._uiApiLayout()-->
					<button type="button" class="btn btn-alt-secondary" data-toggle="layout" data-action="sidebar_toggle">
						<i class="fa fa-fw fa-bars"></i>
					</button>
					<!-- END Toggle Sidebar -->
				</div>
				<!-- END Left Section -->

				<!-- Right Section -->
				<div class="space-x-1">
					<!-- User Dropdown -->
					{{-- <div class="dropdown d-inline-block">
						<button type="button" class="btn btn-alt-secondary" id="page-header-user-dropdown" data-bs-toggle="dropdown"
							aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-fw fa-user d-sm-none"></i>
							<span class="d-none d-sm-inline-block">Admin</span>
							<i class="fa fa-fw fa-angle-down opacity-50 ms-1 d-none d-sm-inline-block"></i>
						</button>
						<div class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="page-header-user-dropdown">
							<div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
								User Options
							</div>
							<div class="p-2">
								<a class="dropdown-item" href="javascript:void(0)">
									<i class="far fa-fw fa-user me-1"></i> Profile
								</a>
								<a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)">
									<span><i class="far fa-fw fa-envelope me-1"></i> Inbox</span>
									<span class="badge bg-primary rounded-pill">3</span>
								</a>
								<a class="dropdown-item" href="javascript:void(0)">
									<i class="far fa-fw fa-file-alt me-1"></i> Invoices
								</a>
								<div role="separator" class="dropdown-divider"></div>

								<!-- Toggle Side Overlay -->
								<!-- Layout API, functionality initialized in Template._uiApiLayout() -->
								<a class="dropdown-item" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_toggle">
									<i class="far fa-fw fa-building me-1"></i> Settings
								</a>
								<!-- END Side Overlay -->

								<div role="separator" class="dropdown-divider"></div>
								<a class="dropdown-item" href="javascript:void(0)">
									<i class="far fa-fw fa-arrow-alt-circle-left me-1"></i> Sign Out
								</a>
							</div>
						</div>
					</div> --}}
					<!-- END User Dropdown -->
					@include('layouts.partials.userpanel')
				</div>
				<!-- END Right Section -->
			</div>
			<!-- END Header Content -->

			<!-- Header Loader -->
			<!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
			<div id="page-header-loader" class="overlay-header bg-header-dark">
				<div class="bg-white-10">
					<div class="content-header">
						<div class="w-100 text-center">
							<i class="fa fa-fw fa-sun fa-spin text-white"></i>
						</div>
					</div>
				</div>
			</div>
			<!-- END Header Loader -->
		</header>
		<!-- END Header -->

		<!-- Main Container -->
		<main id="main-container">
			@yield('content')
		</main>
		<!-- END Main Container -->
		@include('layouts.partials.modal-confirm')

		<!-- Footer -->
		@include('layouts.partials.footer')
		<!-- END Footer -->
	</div>
	<!-- END Page Container -->
	<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js', true) }}"></script>
	<script>
		jQuery(function() {
			// Dashmix.helpers('notify');
			Dashmix.helpersOnLoad(['jq-notify']);
		});
	</script>
	@yield('js_end')
</body>

</html>
