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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Details</h1>
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


    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">

            <!--begin::Card-->
            <div class="card">
                <div class="card-body ">

                    <div class="row">
                        <div class="col-md-4" style="margin-top: -15px;">
                            <img src="{{ asset('uploads/product_image/'.$product->product_image) }}" style="height: 150px; width: 200px;"><br><br>
                        </div>

                        <div class="col-md-3" style="margin-top: 15px;">
                            <li style="font-size: 15px;"><b>Name - </b>{{ $product->product_name }}</li>
                            <li class="mt-1" style="font-size: 15px;"><b>Code - </b>{{ $product->product_code }}</li>
                            <li class="mt-1" style="font-size: 15px;"><b>Category - </b>{{ $product->categoryData->category_name }}</li>
                            <li class="mt-1" style="font-size: 15px;"><b>Brand - </b>{{ $product->brandData->brand_name }}</li>
                            <li class="mt-1" style="font-size: 15px;"><b>Unit - </b>{{ $product->unitData->unit_name }}</li>
                        </div>

                        <div class="col-md-3" style="margin-top: 15px;">
                            <li style="font-size: 15px;"><b>Purchase Price - </b>{{ $product->purchase_price }} </li>
                            <li style="font-size: 15px;"><b>Selling Price - </b>{{ $product->selling_price }} </li>
                            <li class="mt-1" style="font-size: 15px;"><b>Details - </b>{{ $product->solid_product_details }}</li>
                            <li class="mt-1" style="font-size: 15px;"><b>Stock Alert - </b>{{ $product->stock_alert }}</li>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('product.edit',$product->id) }}" class="btn btn-primary">Edit</a>
                        </div>
                    </div>

                   

                </div>
                <!--end::Card body-->
            </div>

        </div>
        <!--end::Container-->
    </div><br><br>

</div>

@endsection
