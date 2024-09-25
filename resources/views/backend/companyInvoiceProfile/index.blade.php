@extends('backend.master')
@section('content')
@section('title') Shop Invoice Profile @endsection
@section('companyInvoiceProfile') active @endsection
@section('companyInvoiceProfile') active @endsection
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
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Shop Invoice Profile</h1>
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
                    <li class="breadcrumb-item text-muted">Shop Invoice Profile</li>
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
                        <h2>Shop Invoice Profile</h2>
                    </div>
                    <!--end::Card title-->
                </div>

                <div class="card-body">
                    <!--begin::Form-->
                    <form method="POST"
                        action="{{ route('companyInvoiceProfile.update', $companyInvoiceProfile->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="container-xxl">

                            <div class="row">
                                <div class="col-md-3  mb-7">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Shop Logo </label>
                                        <input type="file" name="shop_logo" id="shop_logo"
                                            class="custom-file-input mt-1 mb-3" id="customFile">
                                    </div>

                                    @if(isset($companyInvoiceProfile->shop_logo))
                                        <img src="{{ asset('uploads/shop_logo/'.$companyInvoiceProfile->shop_logo) }}"
                                            style="height: 100px; width: 150px; ">
                                    @endif
                                </div>


                                <div class="col-md-3  mb-7">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Billing Seal </label>
                                        <input type="file" name="billing_seal" id="billing_seal"
                                            class="custom-file-input mt-1 mb-3" id="customFile">
                                    </div>

                                    @if(isset($companyInvoiceProfile->billing_seal))
                                        <img src="{{ asset('uploads/billing_seal/'.$companyInvoiceProfile->billing_seal) }}"
                                            style="height: 100px; width: 150px; ">
                                    @endif
                                </div>


                                <div class="col-md-3  mb-7">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Billing Signature </label>
                                        <input type="file" name="billing_signature" id="billing_signature"
                                            class="custom-file-input mt-1 mb-3" id="customFile">
                                    </div>

                                    @if(isset($companyInvoiceProfile->billing_signature))
                                        <img src="{{ asset('uploads/billing_signature/'.$companyInvoiceProfile->billing_signature) }}"
                                            style="height: 100px; width: 150px; ">
                                    @endif
                                </div>


                                <div class="col-md-3 mb-7">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Trade License </label>
                                        <input type="file" name="trade_license" id="trade_license"
                                            class="custom-file-input mt-1 mb-3" id="customFile">
                                    </div>

                                    @if(isset($companyInvoiceProfile->trade_license))
                                        <img src="{{ asset('uploads/trade_license/'.$companyInvoiceProfile->trade_license) }}"
                                            style="height: 100px; width: 150px; ">
                                    @endif
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="name" class="form-label">Name <span class=" text-danger">(required)</span> </label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                            value="{{ $companyInvoiceProfile->name }}" required>

                                        @error('name')
                                            <span class=text-danger>{{ $message }}</span>
                                        @enderror

                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="company_slogan" class="form-label">Company Slogan</label>
                                        <input type="text" class="form-control" name="company_slogan"
                                            id="company_slogan" placeholder="Company Slogan"
                                            value="{{ $companyInvoiceProfile->company_slogan }}">
                                    </div>
                                </div>

                            </div>



                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-5">
                                        <label for="tax" class="form-label">Tax/Vat/GST</label>
                                        <input type="text" class="form-control" name="tax" id="tax"
                                            placeholder="Tax/Vat/GST" value="{{ $companyInvoiceProfile->tax }}">
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="mb-5">
                                        <label for="tin" class="form-label">TIN</label>
                                        <input type="text" class="form-control" name="tin" id="tin" placeholder="TIN"
                                            value="{{ $companyInvoiceProfile->tin }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-5">
                                        <label for="currency" class="form-label">Currency</label>
                                        <input type="text" class="form-control" name="currency" id="currency"
                                            placeholder="Currency" value="{{ $companyInvoiceProfile->currency }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-5">
                                        <label for="currency_symble" class="form-label">Currency Symble</label>
                                        <input type="text" class="form-control" name="currency_symble"
                                            id="currency_symble" placeholder="Currency Symble"
                                            value="{{ $companyInvoiceProfile->currency_symble }}">
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="mobile" class="form-label">Contact Number <span class=" text-danger">(required)</span> </label>
                                        <input type="text" class="form-control" name="mobile" id="mobile"
                                            placeholder="Contact Number" value="{{ $companyInvoiceProfile->mobile }}" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Email Address" value="{{ $companyInvoiceProfile->email }}">
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="address_line_1" class="form-label">Address Line 1</label>
                                        <input type="text" class="form-control" name="address_line_1"
                                            id="address_line_1" placeholder="Address Line 1"
                                            value="{{ $companyInvoiceProfile->address_line_1 }}">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="address_line_2" class="form-label">Address Line 2</label>
                                        <input type="text" class="form-control" name="address_line_2"
                                            id="address_line_2" placeholder="Address Line 2"
                                            value="{{ $companyInvoiceProfile->address_line_2 }}">
                                    </div>
                                </div>

                            </div>




                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <input type="text" class="form-control" name="facebook" id="facebook"
                                            placeholder="Facebook" value="{{ $companyInvoiceProfile->facebook }}">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="twitter" class="form-label">Twitter</label>
                                        <input type="text" class="form-control" name="twitter" id="twitter"
                                            placeholder="Twitter" value="{{ $companyInvoiceProfile->twitter }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="website" class="form-label">Website</label>
                                        <input type="text" class="form-control" name="website" id="website"
                                            placeholder="Website" value="{{ $companyInvoiceProfile->website }}">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-5">
                                        <label for="website" class="form-label">Website</label>
                                        <select class="form-control" name="status">
                                            <option value="1"
                                                {{ $companyInvoiceProfile->status == 1 ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0"
                                                {{ $companyInvoiceProfile->status == 0 ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="btn btn-group">

                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="hidden form-check-input" id="invoice_design"
                                            name="invoice_design" value="1"
                                            {{ $companyInvoiceProfile->invoice_design == 1 ? 'checked' : '' }} />
                                        <img src="./../backend/invoice/invoice1.png"
                                            style="height: 180px; width: 140px;">
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="hidden form-check-input" id="invoice_design"
                                            name="invoice_design" value="2"
                                            {{ $companyInvoiceProfile->invoice_design == 2 ? 'checked' : '' }} />
                                        <img src="./../backend/invoice/invoice2.jpg"
                                            style="height: 180px; width: 140px;">
                                    </div>


                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="hidden form-check-input" id="invoice_design"
                                            name="invoice_design" value="3"
                                            {{ $companyInvoiceProfile->invoice_design == 3 ? 'checked' : '' }} />
                                        <img src="./../backend/invoice/invoice3.jpg"
                                            style="height: 180px; width: 140px;">
                                    </div>


                                </div>
                            </div>



                            <div class="row">
                                <div class="col-6">
                                    <input type="submit" class="btn text-white" style="background-color: #2F4F4F">
                                </div>
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
