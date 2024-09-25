@extends('backend.master')
@section('content')
@section('title') Customer Group Create @endsection
@section('customer-group') active @endsection
@section('customer-group.create') active @endsection
@section('styles')
@endsection
@section('content')

		<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						<!--begin::Toolbar-->
						<div class="toolbar" id="kt_toolbar">
							<!--begin::Container-->
							<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
								<!--begin::Page title-->
								<div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
									<!--begin::Title-->
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">New Customer Group</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-300 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="/metronic8/demo1/../demo1/index.html" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">Customer Group Create</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										
									</ul>
									<!--end::Breadcrumb-->
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
								<div class="card">
									<!--begin::Card header-->
									<div class="card-header border-0 pt-6">
										<!--begin::Card title-->
										<div class="card-title">
											<!--begin::Search-->
											<div class="d-flex align-items-center position-relative my-1">
												<h4>Customer Group Create...</h4>
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

												@can('customer-group-list')
												<a href="{{route('customer-group.index')}}" class="btn text-white" style="background-color: #2F4F4F">Customer Group List</a>
												@endcan
												<!--end::Add customer-->
											</div>
											
										</div>
										<!--end::Card toolbar-->
									</div><br>
									<!--end::Card header-->
									<!--begin::Card body-->

									<div class="card-body pt-0">
									 <form action="{{route('customer-group.store')}}" method="post" enctype="multipart/form-data">
									 @csrf	
										<div class="row">
											<div class="col-md-6">
												<div class="mb-5">
												  <label for="group_name" class="form-label">Customer Group Name <span class=" text-danger">(required)</span> </label>
												  <input type="text" class="form-control" name="group_name" id="group_name" placeholder=" Customer Group Name" required>

												  @error('group_name')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror

												</div>
											</div>

											<div class="col-md-6">
												<div class="mb-5">
												  <label for="discount" class="form-label">Discount % <span class=" text-danger">(required)</span> </label>
												  <input type="text" class="form-control" name="discount" id="discount" placeholder="Discount %" required>

												  @error('discount')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror

												</div>
											</div>
											
										</div>


										<div class="row">
											<div class="col-6">
												<input type="submit" class="btn text-white" style="background-color: #2F4F4F">
											</div>
										</div>

									</form>	
									</div>
									<!--end::Card body-->
								</div>

							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
					</div>

@endsection