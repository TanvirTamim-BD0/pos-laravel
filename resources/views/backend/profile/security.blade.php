@extends('backend.master')
@section('content')
@section('title') Profile @endsection
@section('profile') active @endsection
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
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Profile</h1>
									<!--end::Title-->
									<!--begin::Separator-->
									<span class="h-20px border-gray-300 border-start mx-4"></span>
									<!--end::Separator-->
									<!--begin::Breadcrumb-->
									<ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">
											<a href="" class="text-muted text-hover-primary">Home</a>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item text-muted">Account</li>
										<!--end::Item-->
										<!--begin::Item-->
										<li class="breadcrumb-item">
											<span class="bullet bg-gray-300 w-5px h-2px"></span>
										</li>
									</ul>
									<!--end::Breadcrumb-->
								</div>
								
							</div>
							<!--end::Container-->
						</div>



						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								<!--begin::Navbar-->

								@include('backend.profile.menu')


								<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
									<!--begin::Card header-->
									<div class="card-header cursor-pointer">
										<!--begin::Card title-->
										<div class="card-title m-0">
											<h3 class="fw-bolder m-0">Security Setting</h3>
										</div>
									</div>

									<div class="card-body p-9">
									<form action="{{route('profile.security.update')}}" method="post">
										@csrf
										<!--begin::Row-->
										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Old Password : </label>
											<div class="col-lg-6">
												  <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password">
												  @error('old_password')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">New Password : </label>
											<div class="col-lg-6">
												  <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password">
												  @error('new_password')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Confirm Password : </label>
											<div class="col-lg-6">
												  <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
												  @error('confirm_password')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>

										<div class="row mb-7">
											<div class="col-lg-6">
												  <input type="submit" class="btn text-white" style="background-color: #2F4F4F">
											</div>
										</div>

									</form>
										
									
									</div>
									<!--end::Card body-->
								</div>
								<!--end::details View-->


							</div>
							<!--end::Container-->
						</div>
						<!--end::Post-->
	</div>
					
@endsection