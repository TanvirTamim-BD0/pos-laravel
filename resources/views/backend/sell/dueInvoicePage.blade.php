@extends('backend.master')
@section('content')
    @section('title') Due Paid @endsection
    @section('purchase') active @endsection
    @section('purchase.create') active @endsection
@section('styles')
    
     <style>
    
        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
            margin-top: 3rem;
        }
        .card {
            border: 0;
            border-radius: 0;
            margin-bottom: 30px;
            transition: .5s;
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color:#fff;
            background-clip: border-box;
        }
        .invoice-header {
            width: 100%;
            display: block;
            box-sizing: border-box;
            overflow: hidden;
        }
        .invoice-header .logo-area {
            width: 50%;
            float: left;
            padding: 5px;
        }
        .logo-area img {
            width: 25%;
            display: inline;
            float: left;
        }
        .logo-area h4 {
            font-weight: bold;
            margin-top: 5px;
        }
        .bill-no, .date, .name, .mobile-no, .address, th, td, address, h4 {
            color: #000;
        }
        h4, .h4 {
            font-size: 19px;
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: 'Roboto',sans-serif;
            line-height: 1.5;
            letter-spacing: .5px;
        }
        h4 {
            display: block;
            margin-block-start: 1.33em;
            margin-block-end: 1.33em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
        }
        .invoice-header address {
            width: 50%;
            float: left;
            padding: 5px;
        }
        address {
            margin-bottom: 0;
            display: block;
            font-style: normal;
            line-height: inherit;
        }
        strong {
            font-weight: 800;
        }
        .bill-date {
            width: 100%;
            border: 1px solid #ccc;
            overflow: hidden;
            padding: 0 15px;
        }
        .bill-no {
            width: 50%;
            float: left;
        }
        .date {
            width: 50%;
            float: left;
        }
        .name, .address, .mobile-no, .cus_info {
            width: 100%;
            border-left: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-right: 1px solid #ccc;
            padding: 0 15px;
        }
        .my-3 {
            margin-top: 1rem!important;
            margin-bottom: 1rem!important;
        }

        .table-bordered {
            border: 1px solid #e9ecef;
        }
        .table {
            width: 100%;
            max-width: 100%;
            background-color: transparent;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            display: table;
            text-indent: initial;
            border-spacing: 2px;
            border-collapse: collapse;
        }
        .bg-primary {
            background-color: #33cabb !important;
            color: #fff;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table tbody th {
            border-top: 1px solid #eceeef;
        }
        .table-plist th {
            padding: 5px;
            text-align: center;
            background: #ddd;
        }
        .order-details th {
            font-weight: bold;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #e9ecef;
        }
        .table td, .table th {
            vertical-align: top;
        }
        th{
            display: table-cell;
        }
        .btn-secondary {
            color: #616a78;
            background-color: #e4e7ea;
            border-color: #e4e7ea;
        }
        .btn {
            font-size: 14px;
            padding: 5px 16px;
            line-height: inherit;
            letter-spacing: 1px;
            border-radius: 2px;
            outline: none !important;
            transition: 0.15s linear;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;   
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        button, input, optgroup, select, textarea {
            font-family: 'Roboto',sans-serif;
            margin: 0;
        }
        [type=reset], [type=submit], button, html [type=button] {
            -webkit-appearance: button;
        }
        button, select {
            text-transform: none;
        }
        button, input {
            overflow: visible;
        }
        [role=button], a, area, button, input, label, select, summary, textarea {
            touch-action: manipulation;
        }
        button {
            writing-mode: horizontal-tb !important;
            text-rendering: auto;
            word-spacing: normal;
            text-indent: 0px;
            text-shadow: none;
            align-items: flex-start;
            cursor: default;
        }
        .btn-block+.btn-block {
            margin-top: 0.5rem;
        }

        .fa {
            display: inline-block;
            font: normal normal normal 14px/1;
            font-size: inherit;
            text-rendering: auto;
        }
    </style>


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
                    <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Sale Due Invoice</h1>
                    <!--end::Title-->
                    <!--begin::Separator-->
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <!--end::Separator-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">Sale Due Invoice</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>

            </div>
            <!--end::Container-->
        </div>

        @php
            $setting = App\Models\Setting::first();
        @endphp


                <div style="margin-left: 40px;">
            <a data-bs-toggle="modal" data-bs-target="#kt_modal_new_address"><button class="btn btn-sm btn-primary">Paid Amount</button></a>
        </div>

        <div class="modal" id="kt_modal_new_address" tabindex="-1" aria-modal="true" role="dialog">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form method="post" action="{{route('sell-due-payment')}}">
                    @csrf
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_new_address_header">
                            <!--begin::Modal title-->
                            <h2>Sell Due Payment</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_new_address_header" data-kt-scroll-wrappers="#kt_modal_new_address_scroll" data-kt-scroll-offset="300px" style="max-height: 163px;">
                                
                                <input type="hidden" value="{{ $sellData->id }}" name="sell_id">

                                <div class="row mb-5">
                                    <div class="col-md-6 fv-row fv-plugins-icon-container">
                                        <label class="required fs-5 fw-bold mb-2">Amount</label>
                                        <input type="text" class="form-control form-control-solid" placeholder="Amount" name="due_amount">
                                    <div class="fv-plugins-message-container invalid-feedback"></div></div>


                                   <div
                                                                    class="col-md-6 fv-row fv-plugins-icon-container">
                                                                    <div class="form-group">
                                                                        <label
                                                                            class="required fs-5 fw-bold mb-2">
                                                                            Date</label>
                                                                        <div
                                                                            class="fv-row fv-plugins-icon-container p-0 m-0">
                                                                            <div
                                                                                class="position-relative d-flex align-items-center">
                                                                                <span
                                                                                    class="svg-icon position-absolute ms-4 mb-1 svg-icon-2" style="left:25%;">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24" fill="none">
                                                                                        <path opacity="0.3"
                                                                                            d="M21 22H3C2.4 22 2 21.6 2 21V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5V21C22 21.6 21.6 22 21 22Z"
                                                                                            fill="black"></path>
                                                                                        <path
                                                                                            d="M6 6C5.4 6 5 5.6 5 5V3C5 2.4 5.4 2 6 2C6.6 2 7 2.4 7 3V5C7 5.6 6.6 6 6 6ZM11 5V3C11 2.4 10.6 2 10 2C9.4 2 9 2.4 9 3V5C9 5.6 9.4 6 10 6C10.6 6 11 5.6 11 5ZM15 5V3C15 2.4 14.6 2 14 2C13.4 2 13 2.4 13 3V5C13 5.6 13.4 6 14 6C14.6 6 15 5.6 15 5ZM19 5V3C19 2.4 18.6 2 18 2C17.4 2 17 2.4 17 3V5C17 5.6 17.4 6 18 6C18.6 6 19 5.6 19 5Z"
                                                                                            fill="black"></path>
                                                                                        <path
                                                                                            d="M8.8 13.1C9.2 13.1 9.5 13 9.7 12.8C9.9 12.6 10.1 12.3 10.1 11.9C10.1 11.6 10 11.3 9.8 11.1C9.6 10.9 9.3 10.8 9 10.8C8.8 10.8 8.59999 10.8 8.39999 10.9C8.19999 11 8.1 11.1 8 11.2C7.9 11.3 7.8 11.4 7.7 11.6C7.6 11.8 7.5 11.9 7.5 12.1C7.5 12.2 7.4 12.2 7.3 12.3C7.2 12.4 7.09999 12.4 6.89999 12.4C6.69999 12.4 6.6 12.3 6.5 12.2C6.4 12.1 6.3 11.9 6.3 11.7C6.3 11.5 6.4 11.3 6.5 11.1C6.6 10.9 6.8 10.7 7 10.5C7.2 10.3 7.49999 10.1 7.89999 10C8.29999 9.90003 8.60001 9.80003 9.10001 9.80003C9.50001 9.80003 9.80001 9.90003 10.1 10C10.4 10.1 10.7 10.3 10.9 10.4C11.1 10.5 11.3 10.8 11.4 11.1C11.5 11.4 11.6 11.6 11.6 11.9C11.6 12.3 11.5 12.6 11.3 12.9C11.1 13.2 10.9 13.5 10.6 13.7C10.9 13.9 11.2 14.1 11.4 14.3C11.6 14.5 11.8 14.7 11.9 15C12 15.3 12.1 15.5 12.1 15.8C12.1 16.2 12 16.5 11.9 16.8C11.8 17.1 11.5 17.4 11.3 17.7C11.1 18 10.7 18.2 10.3 18.3C9.9 18.4 9.5 18.5 9 18.5C8.5 18.5 8.1 18.4 7.7 18.2C7.3 18 7 17.8 6.8 17.6C6.6 17.4 6.4 17.1 6.3 16.8C6.2 16.5 6.10001 16.3 6.10001 16.1C6.10001 15.9 6.2 15.7 6.3 15.6C6.4 15.5 6.6 15.4 6.8 15.4C6.9 15.4 7.00001 15.4 7.10001 15.5C7.20001 15.6 7.3 15.6 7.3 15.7C7.5 16.2 7.7 16.6 8 16.9C8.3 17.2 8.6 17.3 9 17.3C9.2 17.3 9.5 17.2 9.7 17.1C9.9 17 10.1 16.8 10.3 16.6C10.5 16.4 10.5 16.1 10.5 15.8C10.5 15.3 10.4 15 10.1 14.7C9.80001 14.4 9.50001 14.3 9.10001 14.3C9.00001 14.3 8.9 14.3 8.7 14.3C8.5 14.3 8.39999 14.3 8.39999 14.3C8.19999 14.3 7.99999 14.2 7.89999 14.1C7.79999 14 7.7 13.8 7.7 13.7C7.7 13.5 7.79999 13.4 7.89999 13.2C7.99999 13 8.2 13 8.5 13H8.8V13.1ZM15.3 17.5V12.2C14.3 13 13.6 13.3 13.3 13.3C13.1 13.3 13 13.2 12.9 13.1C12.8 13 12.7 12.8 12.7 12.6C12.7 12.4 12.8 12.3 12.9 12.2C13 12.1 13.2 12 13.6 11.8C14.1 11.6 14.5 11.3 14.7 11.1C14.9 10.9 15.2 10.6 15.5 10.3C15.8 10 15.9 9.80003 15.9 9.70003C15.9 9.60003 16.1 9.60004 16.3 9.60004C16.5 9.60004 16.7 9.70003 16.8 9.80003C16.9 9.90003 17 10.2 17 10.5V17.2C17 18 16.7 18.4 16.2 18.4C16 18.4 15.8 18.3 15.6 18.2C15.4 18.1 15.3 17.8 15.3 17.5Z"
                                                                                            fill="black"></path>
                                                                                    </svg>
                                                                                </span>
                                                                                <!--end::Svg Icon-->
                                                                                <input
                                                                                    class="form-control form-control-solid flatpickr-input active producut_menufacture_date"
                                                                                    name="date"
                                                                                    placeholder="Pick a date"
                                                                                    id="date"
                                                                                    type="text" readonly="readonly"
                                                                                    value="">
                                                                            </div>
                                                                            <div
                                                                                class="fv-plugins-message-container invalid-feedback">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                </div>

                                <!--end::Input group-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer" style="margin-right: 40px;">
                            <!--begin::Button-->
                            <button type="reset" id="kt_modal_new_address_cancel" class="btn btn-light me-3" >Discard</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button type="submit" id="kt_modal_new_address_submit" class="btn btn-primary">
                                <span class="indicator-label">Paid</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                    <div></div></form>
                    <!--end::Form-->
                </div>
            </div>
        </div>



        <div class="container">
        <div class="card card-body">
         <!--    <div id="print-area">
                <div class="invoice-header">
                    <div class="logo-area">
                        <img src="{{ asset('uploads/logo_image/'.$setting->logo_image) }}" alt="logo" data-pagespeed-url-hash="3425423219" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
                        <div class="clearfix"></div>
                        <h4>{{$setting->company_name}}</h4>
                    </div>
                    <address>
                        Address : <strong>{{$setting->address_line_1}}</strong>
                        <br>
                        Phone : <strong>{{$setting->mobile}}</strong>
                        <br>
                        Email : <strong>{{$setting->email}}</strong>
                        
                    </address>

                </div>

                <div class="bill-date">
                    <div class="bill-no">
                        Invoice No: {{$sellData->selling_id}}
                    </div>
                    <div class="date">
                        Date: <strong>{{ $sellData->created_at->toDateString() }}</strong>
                    </div>
                </div>

                <div class="name">
                    Customer Name :
                    <span>{{$customerData->customer_name}}</span>
                </div>

                <div class="address">
                    Address : <span>{{ $customerData->customer_address }}</span>
                </div>

                <div class="mobile-no">
                    Mobile : <span>{{$customerData->customer_phone}}</span>
                </div>

                
                
                <table class="table table-bordered table-plist my-3 order-details">
                    <tbody>
                        <tr class="bg-primary">
                            <th>#</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Total Price</th>
                        </tr>


                        <tr>
                             @foreach($sellProducts as $key=>$productData)
                                    @if(isset($productData))
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $sellData->customerData->customer_name }}</td>
                                        <td>{{ $productData->productData->product_name }}</td>
                                        <td>{{ $productData->product_qty }}</td>
                                        <td>{{ $productData->product_price }}tk</td>
                                    </tr>
                                    @endif
                            @endforeach
                        </tr>

                        <tr>
                            <td colspan="4" class="text-right"> Grand Total : </td>
                            <td>
                                <strong>{{$totalProductAmount}}</strong>Tk
                            </td>
                        </tr>
                    
                        <tr>
                            <td colspan="4" class="text-right">Paid : </td>
                            <td>
                                <strong>{{$paidAmount}} </strong>Tk
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="margin-right: 100px;">Due : </td>
                            <td>
                                <strong>{{$dueAmount}} </strong>Tk
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="margin-right: 100px;">Tax : </td>
                            <td>
                                <strong>{{$totalTax}} </strong>Tk
                            </td>
                        </tr>

                        <tr>
                            <td colspan="4" style="margin-right: 100px;">Discount : </td>
                            <td>
                                <strong>{{$discount}} </strong>Tk
                            </td>
                        </tr>

                    </tbody>
                </table>


            </div>
            <button class="btn btn-secondary btn-block" onclick="print_receipt('print-area')">
                <i class="fa fa-print"></i>
                Print
            </button>
            <a href="{{route('sell.index')}}" class="btn btn-primary btn-block">
                <i class="fa fa-reply"></i>
                Back
            </a> -->


             <h4 style=" text-align: center;">Due Payment History</h4>
            <table class="table table-bordered table-plist my-3 order-details">
                    <tbody>
                        <tr class="bg-primary">
                            <th>#</th>
                            <th>Paid Amount</th>
                            <th>Date</th>
                        </tr>

                        @foreach($sellDuePaymentHistroy as $sellDuePayment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sellDuePayment->due_amount }}</td>
                            <td>{{ $sellDuePayment->date }}</td>
                        </tr>
                        @endforeach
                            
                    </tbody>
                </table>

        </div>
    </div>

    </div> 
</div>

@endsection


<script>
    localStorage.removeItem('pos-items');
    function print_receipt(divName){
        let printDoc=$('#'+divName).html();
        let originalContents=$('body').html();
        $("body").html(printDoc);
        window.print();
        $('body').html(originalContents);
        }
</script>

@section('scripts')
    <script
        src="{{ asset('/backend/assets/js/custom/apps/projects/settings/settings.js') }}">
    </script>

    <script>
        $(".producut_menufacture_date").flatpickr()
    </script>
    @endsection
