@extends('layouts.backend')

@section('css')
	<!-- Page JS Plugins CSS -->
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css', true) }}">
	<link rel="stylesheet" href="{{ asset('js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css', true) }}">
@endsection

@section('js')
	<!-- jQuery (required for DataTables plugin) -->
	<script src="{{ asset('js/lib/jquery.min.js') }}"></script>

	<!-- Page JS Plugins -->
	<script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
	<script src="/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
	<script src="/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
	{{-- <script src="{{ asset('js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script> --}}

	<!-- Page JS Code -->
	{{-- @vite(['resources/js/pages/datatables.js']) --}}
@endsection

@section('content')
	<!-- Hero -->
	<div class="bg-body-light">
		<div class="content content-full">
			<div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
				<h1 class="flex-grow-1 fs-3 fw-semibold my-2 my-sm-3">{!! $heading !!}</h1>
			</div>
		</div>
	</div>
	<!-- END Hero -->

	<!-- Page Content -->
	<div class="content">

		@yield('pretable')

		<!-- Dynamic Table Full -->
		<div class="block block-rounded">
			<div class="block-header block-header-default">
				@yield('header')
			</div>
			<div class="block-content block-content-full">
				<table class="table responsive table-bordered table-hover text-nowrap" id="datatable" style="width: 100%;">
					<thead>
						@yield('thead')
					</thead>
				</table>
			</div>
		</div>
		<!-- END Dynamic Table Full -->
	</div>
	<!-- END Page Content -->
@endsection
