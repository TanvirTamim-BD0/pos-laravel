@extends('backend.master')
@section('content')
@section('title') Invoice @endsection
@section('purchase') active @endsection
@section('purchase.create') active @endsection
@section('styles')

<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

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
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Purchase Invoice</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Purchase Invoice</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>

            </div>
            <!--end::Container-->
        </div>

        @php
            $setting = App\Models\Setting::first();
        @endphp


        <!--end::Toolbar-->
        <!--begin::Post-->
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!--begin::Container-->
            <div id="kt_content_container" class="container-xxl">
                <!--begin::Invoice 2 main-->
                <div class="card" id="purchaseInvoiceId">
                    <!--begin::Body-->
                    <div class="card-body p-lg-20">
                        <!--begin::Layout-->
                        <div class="d-flex flex-column flex-xl-row">
                            <!--begin::Content-->
                            <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                                <!--begin::Invoice 2 content-->
                                <div class="mt-n1">
                                    <!--begin::Top-->
                                    <div class="d-flex flex-stack pb-10">
                                        <!--begin::Logo-->
                                        <a >
                                            <img alt="Shop Logo"
                                                src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}"
                                                style="height: 50px; width: 200px;" />
                                        </a>
                                        <!--end::Logo-->
                                        <!--begin::Action-->
                                        <div class="">
                                            <a target="_blank" href="{{route('purchase-print-preview',$purchaseData->id)}}" class="btn btn-sm btn-success">Print</a>
                                        </div>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Top-->
                                    <!--begin::Wrapper-->
                                    <div class="m-0">
                                        <!--begin::Label-->
                                        <div class="fw-bolder fs-3 text-gray-800 mb-8">Invoice Number -
                                            {{ $purchaseData->purchase_id }}</div>
                                        <!--end::Label-->
                                        <!--begin::Row-->
                                        <div class="row g-5 mb-11">
                                            <!--end::Col-->
                                            <div class="col-sm-6">

                                            </div>
                                            <!--end::Col-->
                                            <!--end::Col-->
                                            <div class="col-sm-6">
                                                <!--end::Label-->
                                                <div class="fw-bold fs-7 text-gray-600 mb-1">Invoice Date:</div>
                                                <!--end::Label-->
                                                <!--end::Info-->
                                                <div
                                                    class="fw-bolder fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                                    <span
                                                        class="pe-2">{{ $purchaseData->created_at->toDateString() }}</span>
                                                    <span class="fs-7 text-danger d-flex align-items-center">

                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Row-->
                                        <div class="row g-5 mb-12">

                                            <div class="col-sm-6">
                                                <div class="fw-bold fs-7 text-gray-600 mb-1">Shop Details:</div>
                                                <div class="fw-bolder fs-6 text-gray-800">{{$setting->company_name}}</div>
                                                <div class="fw-bold fs-7 text-gray-600">{{$setting->mobile}}
                                                </div>
                                                <div class="fw-bold fs-7 text-gray-600">{{$setting->address_line_1}}
                                                </div>

                                            </div>

                                            <div class="col-sm-6">
                                                <div class="fw-bold fs-7 text-gray-600 mb-1">Issued By:</div>
                                                <div class="fw-bolder fs-6 text-gray-800">
                                                    {{ $supplierData->supplier_name }}</div>
                                                <div class="fw-bold fs-7 text-gray-600">
                                                    {{ $supplierData->supplier_phone }}
                                                    <br />{{ $supplierData->supplier_email }} <br />
                                                    {{ $supplierData->supplier_address }}</div>
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Content-->
                                        <div class="flex-grow-1">
                                            <!--begin::Table-->
                                            <div class="table-responsive border-bottom mb-9">
                                                <table class="table mb-3">
                                                    <thead>
                                                        <tr class="border-bottom fs-6 fw-bolder text-muted">
                                                            <th>NO</th>
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Free Qty</th>
                                                            <th>Total Qty</th>

                                                            <th class="text-end">Total Price</th>
                                                        </tr>

                                                    </thead>
                                                    <tbody>
                                                        @foreach($purchaseProducts as $key=>$productData)
                                                            @if(isset($productData))
                                                                <tr>
                                                                    <td>{{ $key+1 }}</td>
                                                                 
                                                                    <td>{{ $productData->productData->product_name }}
                                                                    </td>
                                                                    <td>{{ $productData->product_qty }} {{ $productData->productData->unitData->unit_name }} </td>
                                                                    <td>{{ $productData->free_product }} {{ $productData->productData->unitData->unit_name }} </td>
                                                                    <td>{{ $productData->total_product }} {{ $productData->productData->unitData->unit_name }} </td>
                                                                    <td class="fw-bolder fs-6 text-gray-800 text-end">
                                                                       {{ number_format($productData->total_product_price) }} </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end::Table-->
                                            <!--begin::Container-->

                                            <!--end::Container-->

                                            <div class="d-flex justify-content-end">
                                                                <!--begin::Section-->
                                                                <div class="mw-300px">
                                                                    <!--begin::Item-->
                                                                    <div class="d-flex flex-stack mb-3">
                                                                        <!--begin::Accountname-->
                                                                        <div class="fw-bold pe-10 text-gray-600 fs-7">Subtotal:</div>
                                                                        <!--end::Accountname-->
                                                                        <!--begin::Label-->
                                                                        <div class="text-end fw-bolder fs-6 text-gray-800">{{ number_format($totalPurchaseAmount) }} </div>
                                                                        <!--end::Label-->
                                                                    </div>
                                                                    
                                                                    <!--end::Item-->
                                                                    <!--begin::Item-->
                                                                    <div class="d-flex flex-stack">
                                                                        <!--begin::Code-->
                                                                        <div class="fw-bold pe-10 text-gray-600 fs-7">Paid :</div>
                                                                        <!--end::Code-->
                                                                        <!--begin::Label-->
                                                                        <div class="text-end fw-bolder fs-6 text-gray-800"> {{ number_format($paidAmount) }} </div>
                                                                        <!--end::Label-->
                                                                    </div>


                                                                    <div class="d-flex flex-stack">
                                                                        <!--begin::Code-->
                                                                        <div class="fw-bold pe-10 text-gray-600 fs-7">Due :</div>
                                                                        <!--end::Code-->
                                                                        <!--begin::Label-->
                                                                        <div class="text-end fw-bolder fs-6 text-gray-800"> {{ number_format($dueAmount) }}</div>
                                                                        <!--end::Label-->
                                                                    </div>
                                                                    
                                                                    <!--end::Item-->
                                                                </div>
                                                                <!--end::Section-->
                                                            </div>

                                        </div>
                                        <!--end::Content-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Invoice 2 content-->
                            </div>


                            <div class="m-0">

                                <div
                                    class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9 bg-lighten">


                                    <!--begin::Section-->
                                    <div class="mw-300px">


                                                                    <div class="d-flex flex-stack mb-3">
                                                                        <!--begin::Accountnumber-->
                                                                        <div class="fw-bold pe-10 text-gray-600 fs-7 mt-2"> Name :</div>
                                                                        <!--end::Accountnumber-->
                                                                        <!--begin::Number-->
                                                                        <div class="text-end fw-bolder fs-6 text-gray-800">{{$userData->name}}</div>
                                                                        <!--end::Number-->
                                                                    </div>

                                                                    <div class="d-flex flex-stack mb-3">
                                                                        <!--begin::Accountnumber-->
                                                                        <div class="fw-bold pe-10 text-gray-600 fs-7 mt-2"> Email :</div>
                                                                        <!--end::Accountnumber-->
                                                                        <!--begin::Number-->
                                                                        <div class="text-end fw-bolder fs-6 text-gray-800">{{$userData->email}}</div>
                                                                        <!--end::Number-->
                                                                    </div>

                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack mb-3">
                                            <!--begin::Accountname-->
                                            <div class="fw-bold pe-10 text-gray-600 fs-7">Payment Method:</div>
                                            <!--end::Accountname-->
                                            <!--begin::Label-->
                                            <div class="text-end fw-bolder fs-6 text-gray-800">
                                                {{ $purchasePayment->payment_type }}</div>
                                            <!--end::Label-->
                                        </div>
                                    

                                        <!--begin::Item-->
                                        <div class="d-flex flex-stack">
                                            <!--begin::Code-->
                                            <div class="fw-bold pe-10 text-gray-600 fs-7">Note:</div>
                                            <!--end::Code-->
                                            <!--begin::Label-->
                                            <div class="text-end fw-bolder fs-6 text-gray-800 mt-2">
                                                {{ $purchasePayment->payment_note }}</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Item-->
                                    </div>
                                    <!--end::Section-->


                                </div>

                            </div>


                        </div>
                        <!--end::Layout-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Invoice 2 main-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Content-->

</div>

@endsection

