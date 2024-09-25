@extends('backend.master')
@section('content')
@section('title') Return @endsection
@section('return') active @endsection
@section('return.index') active @endsection
@section('styles')
@endsection
@section('content')

<style>
.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 7px 14px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination a.active {
  background-color: #2F4F4F;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination a:hover:not(.active) {background-color:#2F4F4F;}
</style>

	
	<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"> Return List</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-300 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									
								</div>
								<!--end::Page title-->
								
							</div>
							<!--end::Container-->
						</div>
						<!--end::Toolbar-->
						<!--begin::Post-->
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">

								<!--begin::Card-->
								<div class="card mt-6">
									<!--begin::Card header-->
									<div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<h3>Return List</h3>
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											
										</div>
										<!--end::Card toolbar-->
									</div><br>

									<div class="card-body pt-0">

										<div class="table-responsive">
											 <table class="table table-striped  gy-7 gs-7">
												  <thead>
												   <tr class="fw-bold fs-6 text-white" style="background-color: #2F4F4F">
												   		<th>SL</th>
												   		<th>Order Number</th>
													    <th>Courier</th>
													    <th>Courier Package</th>
													    <th>Parcel Type</th>
													    <th>Order Status</th>
													    <th>Delevery Options</th>
													    <th>Staff</th>
												   </tr>
												  </thead>

												  <tbody>
												  	
												  </tbody>

											 </table>
										</div>
										
										<div class="pagination mt-2 d-flex justify-content-center">
											 
										</div>
										
									</div>
									<!--end::Card body-->
								</div>

							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>
					
@endsection