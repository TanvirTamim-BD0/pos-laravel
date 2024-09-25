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
											<h3 class="fw-bolder m-0">Profile Details</h3>
										</div>
									</div>

									<div class="card-body p-9">
									<form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
										@csrf
										<!--begin::Row-->
										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Name : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="{{Auth::user()->name}}">
												  @error('name')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Email : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email" value="{{Auth::user()->email}}">
												  @error('email')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Mobile : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter Mobile Number" value="{{Auth::user()->mobile}}">
												  @error('mobile')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Image : </label>
																	<div class="col-lg-6">
																		 <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('../backend/assets/media/svg/avatars/blank.svg')">
																			<!--begin::Preview existing avatar-->
																			@if(isset(Auth::user()->image))
																			
																			 <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ asset('uploads/user_img/'.Auth::user()->image) }});" ></div>

																			@else
										                                       <div class="image-input-wrapper w-125px h-125px" style="background-image: url(../backend/assets/media/avatars/300-1.jpg);"></div>
										                                    @endif

																			<!--end::Preview existing avatar-->
																			<!--begin::Label-->
																			<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Image">
																				<i class="bi bi-pencil-fill fs-7"></i>
																				<!--begin::Inputs-->
																				<input type="file" name="image" accept=".png, .jpg, .jpeg" />
																				<input type="hidden" name="avatar_remove" />
																				<!--end::Inputs-->
																			</label>
																		
																			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel">
																				<i class="bi bi-x fs-2"></i>
																		
																			<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove">
																				<i class="bi bi-x fs-2"></i>
																			</span>
																			
																		</div>
																		
																		<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
																		
																		  @error('image')
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