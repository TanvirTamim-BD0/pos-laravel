
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head><base href="../">
		<title>@yield('title', 'Dashboard')</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 94,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue &amp; Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="Metronic, bootstrap, bootstrap 5, Angular, VueJs, React, Laravel, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic - Bootstrap 5 HTML, VueJS, React, Angular &amp; Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
		<link rel="shortcut icon" href="../backend/assets/media/logos/logo-2.svg" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendor Stylesheets(used by this page)-->
		<link href="../backend/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../backend/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Page Vendor Stylesheets-->
		{{-- External datatable... --}}
		<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
		<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backend') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="../backend/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="../backend/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->

		<!-- @if(Request::is('sell/create'))
			<link rel="stylesheet" href="../backend/new/style.css"> 
		@endif -->

		<link rel="stylesheet" href="../backend/custom.css">

		<!-- Toaster -->
	    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
	     alpha/css/bootstrap.css" rel="stylesheet">
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	    <link rel="stylesheet" type="text/css"
	          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	    
		@yield('styles')

		<style>
			table tbody tr td .menu .menu-item i {
				font-size: 18px;
			}

			.sidebar-zero {
				width: 75px;
			}

			.custom-purchase-add-payment {
				width: 150px;
				padding: 10px 5px !important;
			}
			
			.custom-purchase-add-payment i {
				margin-right: 5px;
			}
			
			.product-purchase-block .table-responsive table {
				border: 1px solid #e1e1e1;
			}

			.custom-payment-table thead {
				border: 1px solid #e1e1e1;
			}
			
			.custom-payment-table thead tr th {
				padding-left: 5px !important;
				padding-right: 5px !important;
				font-weight: 700;
				font-size: 14px;
			}
			
			.custom-payment-table thead tr th span {
				text-align: end;
				float: right;
			}
			
			.custom-payment-table tbody {
				border: 1px solid #e1e1e1 !important;
			}
			
			.custom-payment-table tbody tr {
				border: 0px !important;
			}
			
			.custom-payment-table tbody tr th {
				padding-left: 5px !important;
				padding-right: 5px !important;
				font-weight: 700;
				font-size: 14px;
			}
			
			.custom-payment-table tbody tr th span {
				text-align: end;
				float: right;
			}

			.custom-selling-price-section .card-title hr {
				width: 200px;
				margin:auto;
			}

			.custom-selling-price-card .form-label {
				font-weight: 700;
				margin-top: 15px;
				margin-bottom: 10px;
			}

			.custom-customer-select-option .select2 {
				width: 85% !important;
			}
			
			.custom-customer-select-option .select2-selection {
				border-top-right-radius: 0px !important;
				border-bottom-right-radius: 0px !important;
			}
			
			.custom-customer-select-option .input-group-append {
				width: 15% !important;
			}
			
			.custom-customer-select-option .input-group-append i {
				width: 100%;
				text-align: center;
			}

			table.dataTable {
				border: 1px solid #e5e5e5;
    			padding: 5px 10px 10px 10px;
			}

			table.dataTable.no-footer{
				border-bottom: 1px solid #e5e5e5;
			}

			.dataTables_wrapper .dataTables_filter input {
				background-color: #F5F8FA;
				border-color: #e5e5e5;
				color: #5E6278;
				transition: color 0.2s ease, background-color 0.2s ease;
			}

			div.dataTables_wrapper div.dataTables_length select {
				border: 1px solid #e5e5e5;
				color: #858585;
			}
			
			div.dataTables_wrapper div.dataTables_length select:focus-visible {
				outline: none;
			}
			
			.dataTables_wrapper .dataTables_filter :focus-visible {
				outline: none;
			}

			.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
				z-index: 3;
				color: #FFFFFF !important;
				background: #009EF7 !important;
				border-color: transparent;
			}

			.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
				z-index: 3;
				color: #FFFFFF !important;
				background: #009EF7 !important;
				border-color: transparent;
			}

			.dataTables_wrapper .dataTables_paginate .paginate_button:active {
				box-shadow: none !important;
			}

			.nav-line-tabs.nav-line-tabs-2x .nav-item {
				margin-bottom: -26px;
			}

			.nav-line-tabs .nav-item .nav-link.active, .nav-line-tabs .nav-item .nav-link:hover:not(.disabled), .nav-line-tabs .nav-item.show .nav-link{
				background: #f5f8fa;
    			border-bottom: 1px solid #61b9f3;
			}
			.custom-customer-profile-tab li a {
				margin: 0px !important;
			}

			.menu-sub-dropdown .menu-item a span {
				margin-left: 4px;
				color:black;
			}

			.custom-order-status-block p{
				font-size: 16px;
			}

			.custom-timeline-label {
				width: 80px !important;
			}
			
			.timeline-label:before {
				background-color: transparent !important;
				width: 0px !important;
			}

			.dt-buttons {
				margin-top: 15px;
			}

			button.dt-button, div.dt-button, a.dt-button, input.dt-button {
				border: 1px solid #e5e5e5;
			}
			
			button.dt-button:hover:not(.disabled), div.dt-button:hover:not(.disabled), a.dt-button:hover:not(.disabled), input.dt-button:hover:not(.disabled) {
				border: 1px solid #e5e5e5;
			}

			button.dt-button:active:not(.disabled), button.dt-button.active:not(.disabled), div.dt-button:active:not(.disabled), div.dt-button.active:not(.disabled), a.dt-button:active:not(.disabled), a.dt-button.active:not(.disabled), input.dt-button:active:not(.disabled), input.dt-button.active:not(.disabled){
				background: transparent !important;
				box-shadow: none !important;
			}

			button.dt-button:focus:not(.disabled), div.dt-button:focus:not(.disabled), a.dt-button:focus:not(.disabled), input.dt-button:focus:not(.disabled) {
				border: 1px solid #d2d2d2;
    			text-shadow: 0 1px 0 #c4def1;
			}

			.new-product-batch-block {
				display: none;
			}

			@media (min-width: 1400px){
				.container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl{
					max-width: 100%;
				}
			}
			
			@media (max-width: 768px){
				.custom-customer-select-option .input-group-append .input-group-text {
					padding: 13px 15px !important;
				}
			}
		</style>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	@if(Request::is('sell/create') || Request::is('purchase/create'))
		<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px" cz-shortcut-listen="true" data-kt-aside-minimize="on">
	@else
		<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px"
		>
	@endif
		<!--begin::Main-->
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="page d-flex flex-row flex-column-fluid">

				@include('backend.layout.sidebar')

				<!--begin::Wrapper-->
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

					<!--begin::Header-->
					@include('backend.layout.header')
					<!--end::Header-->

					@yield('content')

					<!--begin::Footer-->
					@include('backend.layout.footer')
					<!--end::Footer-->

				</div>
				<!--end::Wrapper-->

			</div>
			<!--end::Page-->
		</div>
		<!--end::Root-->
		<!--begin::Drawers-->
		<!--begin::Activities drawer-->

		<script src="../backend/custom.js"></script>
		<!--begin::Javascript-->
		<script>var hostUrl = "{{ asset('backend') }}/assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="../backend/assets/plugins/global/plugins.bundle.js"></script>
		<script src="../backend/assets/js/scripts.bundle.js"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Vendors Javascript(used by this page)-->
		<script src="../backend/assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<script src="../backend/assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
		<!--end::Page Vendors Javascript-->
		{{-- Exernal datatable... --}}
		<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>


		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{asset('/backend/assets/js/widgets.bundle.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/widgets.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/apps/chat/chat.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/apps/projects/settings/settings.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/utilities/modals/users-search.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/utilities/modals/create-app.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/utilities/modals/new-address.js')}}"></script>
		<script src="{{asset('/backend/new/app.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/apps/invoices/create.js')}}"></script>
		<script src="{{asset('/backend/assets/js/custom/utilities/modals/new-target.js')}}"></script>
		<script src="{{ asset('backend') }}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
		<!--end::Page Custom Javascript-->

		@yield('scripts')

		<script>
	    @if(Session::has('message'))
	        toastr.options =
	        {
	            "closeButton" : true,
	            "progressBar" : true
	        }
	    toastr.success("{{ session('message') }}");
	    @endif
	        @if(Session::has('error'))
	        toastr.options =
	        {
	            "closeButton" : true,
	            "progressBar" : true
	        }
	    toastr.error("{{ session('error') }}");
	    @endif
	        @if(Session::has('info'))
	        toastr.options =
	        {
	            "closeButton" : true,
	            "progressBar" : true
	        }
	    toastr.info("{{ session('info') }}");
	    @endif
	        @if(Session::has('warning'))
	        toastr.options =
	        {
	            "closeButton" : true,
	            "progressBar" : true
	        }
	    toastr.warning("{{ session('warning') }}");
	    @endif
	</script>


	{{-- For datatable call... --}}
	<script>
		$(document).ready( function () {
			$('#kt_table_customers_payment').DataTable();
		} );
		
		$(document).ready( function () {
			$('#customerParcelListDatatable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#purchaseDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#sellingDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#stockDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#customerDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#customerGroupDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#supplierDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#categoryDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#brandDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#groupDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#unitDataTable').DataTable();
		} );

		$(document).ready( function () {
			$('#taxDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#discountDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#productDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#courierDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#courierPackageDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#parcelTypeDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#deliverOptionDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#orderStatusDataTable').DataTable();
		} );

		$(document).ready( function () {
			$('#parcelDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#deliveredDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#rejectedDataTable').DataTable();
		} );
		
		//All the report data table list...
		$(document).ready( function () {
			$('#sellingReportDataTable').DataTable({
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
		} );


		//All the report data table list...
		$(document).ready( function () {
			$('#purchaseReportDataTable').DataTable({
				dom: 'Bfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print'
				]
			});
		} );

		$(document).ready( function () {
			$('#packageTypeDataTable').DataTable();
		} );
		
		$(document).ready( function () {
			$('#packageDataTable').DataTable();
		} );
	</script>
	

	</body>
	<!--end::Body-->
</html>