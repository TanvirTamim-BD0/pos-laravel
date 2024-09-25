@extends('backend.master')
@section('content')
@section('title') Purchase Report @endsection
@section('purchase-monthly-report-with-month-name') active @endsection
@section('purchase-monthly-report-with-month-name') active @endsection
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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Purchase Monthly Sale Report List</h1>
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
                    <li class="breadcrumb-item text-muted">Purchase Report</li>
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

                    <h3>Search Reports With Month</h3><br>

                    <form action="{{ route('purchase-monthly-report-with-month-name') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mb-5">
                                    <label for="selected_year_name" class="form-label">Select A Year </label>
                                    <select class="form-select" name="selected_year_name" data-control="select2"
                                        data-placeholder="Select A Year" id="selected_year_name">
                                        <option value="" selected>Select A Year</option>
                                        @foreach ($years as $year)
                                            @if(isset($selectedYear))
                                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @else
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('selected_month_name')
                                        <span class=text-danger>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="mb-5">
                                    <label for="selected_month_name" class="form-label">Select A Month </label>
                                    <select class="form-select" name="selected_month_name" data-control="select2"
                                        data-placeholder="Select Month" id="selected_month_name">
                                        <option value="" selected>Select Month</option>
                                        @foreach ($monthNames as $month)
                                            @if(isset($selectedMonth))
                                                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>{{ $month }}</option>
                                            @else
                                                <option value="{{ $month }}">{{ $month }}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                    @error('selected_month_name')
                                        <span class=text-danger>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-3">
                                <input type="submit" value="Search" class="btn text-white"
                                    style="background-color: #2F4F4F">
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
                            <h3>Month Report List</h3>
                        </div>
                        <!--end::Search-->
                    </div>

                </div><br>

                <div class="card-body pt-0">

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                id="purchaseReportDataTable">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                <tr class="text-start text-muted text-uppercase gs-0">
                                    <th>Date</th>
                                    <th>Supllier</th>
                                    <th>Products & Qty</th>
                                    <th>Paid</th>
                                    <th>Due</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach($purchaseData as $data)
                                    @if(isset($data))
                                        <tr>
                                            <td>
                                                {{ $data->created_at->toDateString() }}
                                            </td>
                                            <td>
                                                <a href="{{route('supplier.profile',$data->supplierData->id)}}" class="text-success fw-bolder text-decoration-underline">
                                                    {{ $data->supplierData->supplier_name }}</a>
                                            </td>
                                            <td>
                                                <span class=" fw-bolder">Prodcts: </span>
                                                @foreach($data->purchaseProductData as $product)
                                                    @if($product->productData != null)
                                                        <span class=" badge-light-primary">{{ $product->productData->product_name }} </span> <span class=" text-danger">({{ $product->product_qty }})</span> ,
                                                    @endif
                                                @endforeach
                                            </td>
                                            
                                           
                                            <td>
                                                @if($data->purchasePaymentData != null)
                                                    <span class=" fw-bolder">{{ number_format($data->purchasePaymentData->paid_amount) }}  </span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if($data->purchasePaymentData != null)
                                                    <span class=" fw-bolder">{{ number_format($data->purchasePaymentData->due_amount) }}  </span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if($data->purchasePaymentData != null)
                                                    <span class=" fw-bolder">{{ number_format($data->purchasePaymentData->purchase_amount) }}  </span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach

                                <tr style=" border-top: 1px solid #c3c3c3 !important;">
                                    <td class=" fw-bolder" style="font-weight: 700;">Sub-Total:</td>
                                    <td></td>
                                    <td></td>

                                    <td style="color: #7e15c3; font-weight:700;">
                                       {{ number_format($paidAmount) }} 
                                    </td>

                                    <td style="color: #7e15c3; font-weight:700;">
                                       {{ number_format($dueAmount) }} 
                                    </td>

                                    <td style="color: #11c50b; font-weight:700;">
                                       {{ number_format($totalProductPrice) }} 
                                    </td>
                                   
                                </tr>
                                
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
