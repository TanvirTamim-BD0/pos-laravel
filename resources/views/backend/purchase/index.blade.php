@extends('backend.master')
@section('content')
    @section('title') Purchases @endsection
    @section('purchase') active @endsection
    @section('purchase.index') active @endsection
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
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Purchase List</h1>
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
                        <li class="breadcrumb-item text-muted">Purchases</li>
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
                                <h3>Purchases List</h3>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                                <!--end::Export-->
                                <!--begin::Add customer-->
                                <a href="{{ route('purchase.create') }}" class="btn text-white"
                                    style="background-color: #2F4F4F">Add Purchase</a>
                                <!--end::Add customer-->
                            </div>
                            <!--end::Toolbar-->

                        </div>
                        <!--end::Card toolbar-->
                    </div><br>

                    <div class="card-body pt-0">
                        <div class="no-footer">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                    id="purchaseDataTable">
                                    <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                        <tr class="text-start text-muted text-uppercase gs-0">
                                            <th>SL</th>
                                            <th>Supplier</th>
                                            <th>Product</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fs-6 fw-bold text-gray-600">
                                        @foreach ($purchases as $purchase)
                                            <tr>
                                                <td>
                                                    <a href="{{route('purchase-invoice', $purchase->id)}}" class="text-success fw-bolder text-decoration-underline">
                                                        {{ $purchase->purchase_id }}
                                                    </a>
                                                </td>
                                                <td>{{ $purchase->supplierData->supplier_name }}</td>
                                                <td>
                                                    <span class=" fw-bolder">Prodcts: </span>
                                                    @foreach ($purchase->purchaseProductData as $product)

                                                        @if($product->productData != null)
                                                            <span class=" badge-light-primary">{{ $product->productData->product_name }} </span> ,
                                                        @else
                                                            <span class=" badge-light-primary"> </span> ,
                                                        @endif
                                                    @endforeach
                                                </td>

                                                <td>{{ number_format($purchase->purchasePaymentData->paid_amount) }}</td>
                                                <td>{{ number_format($purchase->purchasePaymentData->due_amount) }} </td>

                                                @php
                                                    $purchaseProductPrice = App\Models\PurchasePayment::getPurchaseProductPrice($purchase->id);   
                                                @endphp

                                                <td>
                                                    <span class="fw-bolder">
                                                         {{ number_format($purchaseProductPrice) }} 
                                                    </span>
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
                                                        <!--end::Svg Icon-->
                                                    </a>

                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                        data-kt-menu="true">

                                                         <div class="menu-item">
                                                            <a href="{{route('purchase-invoice', $purchase->id)}}"
                                                                class="menu-link px-6"><i class="las la-print"></i><span>Invoice</span></a>
                                                        </div>


                                                        <div class="menu-item">

                                                            <form method="POST"
                                                                action="{{ route('purchase.destroy', $purchase->id) }}"
                                                                class="menu-link">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" title="delete"
                                                                    class="bg-transparent border-0">
                                                                    <i class="las la-trash-alt"></i> <span>Delete</span>
                                                                </button>
                                                            </form>

                                                        </div>


                                                    </div>

                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
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
