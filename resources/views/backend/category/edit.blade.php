@extends('backend.master')
@section('content')
@section('title') Category Edit @endsection
@section('category') active @endsection
@section('category') active @endsection
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
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Category</h1>
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
										<li class="breadcrumb-item text-muted">Category Edit</li>
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
												<h4>Category Edit...</h4>
											</div>
											<!--end::Search-->
										</div>
										<!--begin::Card title-->
										<!--begin::Card toolbar-->
										<div class="card-toolbar">
											<!--begin::Toolbar-->
											<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

												@can('category-list')
												<a href="{{route('category.index')}}" class="btn text-white" style="background-color: #2F4F4F">Category List</a>
												@endcan
												
												<!--end::Add customer-->
											</div>
											
										</div>
										<!--end::Card toolbar-->
									</div><br>
									<!--end::Card header-->
									<!--begin::Card body-->

									<div class="card-body pt-0">
									 <form action="{{route('category.update', $category->id)}}" method="post" enctype="multipart/form-data">
									 @csrf	
									 @method('put')
										<div class="row">
											<div class="col-md-8">
												<div class="mb-5">
												  <label for="category_name" class="form-label">Category Name <span class=" text-danger">(required)</span> </label>
												  <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Name" value="{{$category->category_name}}">

												  @error('category_name')
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