@extends('backend.master')
@section('content')
@section('title')  Purchase Edit @endsection
@section('purchase') active @endsection
@section('purchase.create') active @endsection
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
									<h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Purchase</h1>
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
										<li class="breadcrumb-item text-muted">Purchase Edit</li>
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

								<div class="card">
							
									<div class="card-body pt-0 mt-10">

									<h3>Purchase Edit</h3><br>

									 <form action="" method="post">
									 @csrf	
										<div class="row">

											<div class="col-md-6">
												<div class="mb-5">
												 	<label for="supplier_id" class="form-label">Supplier</label>
												  	<select class="form-select" name="supplier_id" data-control="select2" data-placeholder="Select Supplier">
													    <option></option>
													    @foreach($suppliers as $supplier)
													    <option value="{{$supplier->id}}" {{$supplier->id == $purchase->supplier_id ? "selected":""}}>{{$supplier->supplier_name}}</option>
													    @endforeach
													</select>

												  @error('supplier_id')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
												</div>
											</div>

											<div class="col-md-6">
												<div class="mb-5">
												 	<label for="product_id" class="form-label">Product</label>
												  	<select class="form-select" name="product_id" data-control="select2" data-placeholder="Select Category">
													    <option></option>
													    @foreach($products as $product)
													    <option value="{{$product->id}}" {{$product->id == $purchase->product_id ? "selected":""}} >{{$product->product_name}}</option>
													    @endforeach
													</select>

												  @error('product_id')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
												</div>
											</div>

										</div>


										<div class="row">

											<div class="col-md-6">
												<div class="mb-5">
												  <label for="purchase_by" class="form-label">Purchase By</label>
												  <input type="text" class="form-control" name="purchase_by" id="purchase_by" placeholder="Purchase By" value="{{$purchase->purchase_by}}">

												  @error('purchase_by')
				                                    <span class=text-danger>{{$message}}</span>
				                                  @enderror
												</div>
											</div>

										</div>


										<div class="row">
											<div class="col-md-3">
												<input type="submit" value="Submit" class="btn text-white" style="background-color: #2F4F4F">
											</div>
										</div>

									</form>	
									</div>
									
								</div> <br><br>

								<!--begin::Card-->
								<div class="card">
									<div class="card-body pt-0">

										<div class="table-responsive">
											 <table class="table table-striped  gy-7 gs-7">
												  <thead>
												   <tr class="fw-bold fs-6 text-white" style="background-color: #2F4F4F">
												   		<th>Product</th>
													    <th>Qty</th>
													    <th>Sub Total</th>
												   </tr>
												  </thead>

												  <tbody>
												  	
												  </tbody>

											 </table>
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