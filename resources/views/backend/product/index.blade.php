@extends('backend.master')
@section('content')
@section('title') Products @endsection
@section('product') active @endsection
@section('product.index') active @endsection
@section('styles')
@endsection
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Products List</h1>
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
                    <li class="breadcrumb-item text-muted">Products</li>
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

                    <h3>Search Product</h3><br>

                    <form action="{{ route('product.search') }}" method="post">
                        @csrf
                        <div class="row">

                            <div class="col-md-4">
                                <div class="mb-5">
                                    <input type="text" class="form-control" name="product_code" id="product_code"
                                        placeholder="Product Code">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-5">
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                        placeholder="Product Name">
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="mb-5">
                                    <select class="form-control" name="category_id" data-control="select2">
                                        <option selected disabled>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <input type="submit" value="Search" class="btn text-white"
                                    style="background-color: #2F4F4F">

                                <a href="{{ route('product.index') }}" class="btn btn-primary text-white"
                                    >Reset</a>
                            </div>


                        </div>

                    </form>
                </div>

            </div>



            <!--begin::Card-->
            <div class="card mt-6">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <h3>Products List</h3>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                            @can('product-create')
                                <a href="{{ route('product.create') }}" class="btn text-white"
                                    style="background-color: #2F4F4F">Add Product</a>
                            @endcan


                        </div>
                        <!--end::Toolbar-->

                    </div>
                    <!--end::Card toolbar-->
                </div><br>

                <div class="card-body pt-0">

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                id="productDataTable">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                <tr class="text-start text-muted text-uppercase gs-0">
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Purchase Price</th>
                                    <th>Selling Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach($products as $product)
									@if(isset($product))
										<tr>
											<td>{{ $loop->iteration }}</td>
											<td><img src="{{ asset('uploads/product_image/'.$product->product_image) }}"
													width="55" height="45"></td>
											<td>{{ $product->product_code }}</td>
											<td><a href="{{ route('details',$product->id) }}">{{ $product->product_name }}</a></td>
											<td>{{ $product->categoryData->category_name }}</td>
											<td>{{ $product->brandData->brand_name }}</td>
                                            <td>{{ number_format($product->purchase_price) }} </td>
                                            <td>{{ number_format($product->selling_price) }}</td>
											<td>
												@if($product->status == 1)
													<span class="badge badge-light-primary">Active</span>
												@else
													<span class="badge badge-light-danger">Inactive</span>
												@endif
											</td>

											<td>
												<a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click"
																data-kt-menu-placement="bottom-end">Actions
													<span class="svg-icon svg-icon-5 m-0">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
															viewBox="0 0 24 24" fill="none">
															<path
																d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
																fill="black" />
														</svg>
													</span>
													<!--end::Svg Icon--></a>

												<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
													data-kt-menu="true">

													@can('product-status')
														@if($product->status == 1)
															<div class="menu-item">
																<a href="{{ route('product-inactive',$product->id) }}"
																	class="menu-link px-6"> <i class="las la-pen"></i><span
																		>Inactive</span> </a>
															</div>
														@else
															<div class="menu-item">
																<a href="{{ route('product-active',$product->id) }}"
																	class="menu-link px-6"><i class="las la-pen"></i><span
																		>Active</span> </a>
															</div>
														@endif
													@endcan

                                                     @can('product-edit')
                                                        <div class="menu-item">
                                                            <a href="{{ route('details',$product->id) }}"
                                                                class="menu-link px-6"><i class="las la-info-circle"></i><span
                                                                    >Details</span></a>
                                                        </div>
                                                    @endcan


													@can('product-edit')
														<div class="menu-item">
															<a href="{{ route('product.edit',$product->id) }}"
																class="menu-link px-6"><i class="las la-edit"></i><span
																	>Edit</span></a>
														</div>
													@endcan


													@can('product-delete')
														<div class="menu-item">
															<form method="POST"
																action="{{ route('product.destroy', $product->id) }}"
																class="menu-link">
																@csrf
																@method('delete')
																<button type="submit" title="delete"
																	class="bg-transparent border-0">
																	<i class="las la-trash-alt"></i> <span>Delete</span>
																</button>
															</form>
														</div>
													@endcan


                                                   

												</div>
											</td>
										</tr>
									@endif
                                @endforeach
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
