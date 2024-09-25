@extends('backend.master')
@section('content')
@section('title') Shop Setting @endsection
@section('setting') active @endsection
@section('setting') active @endsection
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
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Shop Setting</h1>
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
										<li class="breadcrumb-item text-muted">Shop Setting</li>
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
						
						<div class="post d-flex flex-column-fluid" id="kt_post">
							<!--begin::Container-->
							<div id="kt_content_container" class="container-xxl">
								
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header pt-8">
										<!--begin::Card title-->
										<div class="card-title">
											<h2>Shop Details</h2>
										</div>
										<!--end::Card title-->
									</div>

									<div class="card-body">
										<!--begin::Form-->
										 <form method="POST" action="{{route('setting.update', $setting->id)}}" enctype="multipart/form-data">
                                        	@csrf

										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Logo : </label>
											<div class="col-lg-6">
												  <input type="file" name="logo_image" id="logo_image" class="custom-file-input" id="customFile">
												  @error('logo_image')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>

										</div>

										  <label class="col-lg-4 fw-bold text-muted"> </label>
										  @if(isset($setting->logo_image))
											<img src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}" style="height: 60px; width: 200px; ">
										  @endif


										<div class="row mb-7 mt-5">
											<label class="col-lg-4 fw-bold text-muted">Shop Name : <span class=" text-danger">(required)</span> </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Shop Name" value="{{$setting->company_name}}" required>
												  @error('company_name')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Shop Slogan : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="company_slogan" id="company_slogan" placeholder="Shop Slogan" value="{{$setting->company_slogan}}">
												  @error('company_slogan')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Contact Number : <span class=" text-danger">(required)</span> </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Contact Number" value="{{$setting->mobile}}" required>
												  @error('mobile')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Email Address : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="email" id="email" placeholder="Email Address" value="{{$setting->email}}">
												  @error('email')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Address Line 1: </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="address_line_1" id="address_line_1" placeholder="Address Line 1" value="{{$setting->address_line_1}}">
												  @error('address_line_1')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Address Line 2: </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="address_line_2" id="address_line_2" placeholder="Address Line 2" value="{{$setting->address_line_2}}">
												  @error('address_line_2')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Facebook : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="facebook" id="facebook" placeholder="Facebook" value="{{$setting->facebook}}">
												  @error('facebook')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Twitter : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="twitter" id="twitter" placeholder="Twitter" value="{{$setting->twitter}}">
												  @error('twitter')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>


										<div class="row mb-7">
											<label class="col-lg-4 fw-bold text-muted">Website : </label>
											<div class="col-lg-6">
												  <input type="text" class="form-control" name="website" id="website" placeholder="Website" value="{{$setting->website}}">
												  @error('website')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
											</div>
										</div>



										<div class="row">
											<div class="col-6">
												<input type="submit" class="btn text-white" style="background-color: #2F4F4F">
											</div>
										</div>


										</form>
										<!--end::Form-->
									</div>
									<!--end::Card body-->
								</div>
								<!--end::Card-->
							</div>
							<!--end::Container-->
						</div>

					</div>

@endsection