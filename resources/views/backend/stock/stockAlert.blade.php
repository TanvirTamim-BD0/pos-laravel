@extends('backend.master')
@section('content')
@section('title') Stock @endsection
@section('stock-alert') active @endsection
@section('stockAlert') active @endsection
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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Stock Alert</h1>
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
                    <li class="breadcrumb-item text-muted">Stock Alert</li>
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

            <!-- serch-->

            <!--begin::Card-->
            <div class="card mt-6">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <h3>Stock Alert</h3>
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
                        <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                    id="stockDataTable">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                <tr class="text-start text-muted text-uppercase gs-0">
                                    <th>SL</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Qty</th>
                                </tr>
                            </thead>

       
                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach($productData as $data)

                                	@php
                                	    $stockCount = App\Models\Stock::getProductStockCount($data->id);
                                	@endphp

                                    @if($data->stock_alert > $stockCount)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><img src="{{ asset('/uploads/product_image/'.$data->product_image) }}"
                                                    width="55" height="45"></td>
                                            <td>{{ $data->product_name }}</td>
                                            <td>
                                                <span class="badge badge-light-primary fw-bolder">
                                                    {{ $data->product_code }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-danger fw-bolder">
                                                    {{ $stockCount }}
                                                </span>
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
