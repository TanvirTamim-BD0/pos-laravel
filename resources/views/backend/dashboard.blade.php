@extends('backend.master')
@section('content')

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
       
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            
            <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dashboard</h1>
                
            </div>
            

        </div>
        
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-xl-10">


                <!-- 1 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">

                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #F5DEB3;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Today Sell Amount</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px;">{{ number_format($todaySellingPrice) }} </span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>



                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #98FB98;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Sell Amount</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px;" >{{ number_format($totalSellingPrice) }} </span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                
                </div>



                <!-- 2 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #DCDCDC;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Today Purchase Amount</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class=" fw-bolder me-2 lh-1" style="color: black; font-size: 23px;">{{ number_format($todaypurchasePrice) }} </span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #B0E0E6;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black; ">Total Purchase Amount</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder  me-2 lh-1" style="color: black; font-size: 23px;">{{ number_format($totalpurchasePrice) }} </span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>

                   

                </div>



                <!-- 3 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
                   
                   <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #EEE8AA;">

                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Sell In Amount {{$month}} </span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1"style="color: black; font-size: 23px;" >{{ number_format($totalMonthSellingPrice) }}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #FFEBCD;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Purchase In Amount {{$month}} </span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px; " >{{ number_format($totalMonthPurchasePrice) }} </span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                </div>



                <!-- 4 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #7FFFD4;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Customer</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px; " >{{$totalCustomer}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>

                    
                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #FFFAF0;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Supplier</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class=" fw-bolder me-2 lh-1" style="color: black; font-size: 23px;" >{{$totalSupplier}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                </div>


                <!-- 34223444423423 -->

                <!-- 1 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">

                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #F0FFFF;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Today Expense</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px;">{{ number_format($todayExpensePrice) }} </span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #DCDCDC;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Damage</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px;" >{{$totalDamage}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>

                </div>



                <!-- 2 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #D8BFD8;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Category</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px;" >{{ $totalCategory }}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>

                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #B0C4DE;">

                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total User</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1"style="color: black; font-size: 23px; " >{{$totalUser}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>
                   

                </div>



                <!-- 3 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">
                   
                   <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #FAFAD2;">

                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Product</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1"style="color: black; font-size: 23px;" >{{$totalProduct}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>

                   <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #ADD8E6;">

                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Brand</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1"style="color: black; font-size: 23px;" >{{$totalBrand}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>


                </div>



                <!-- 4 -->
                <div class="col-md-3 col-lg-3 col-xl-3 col-xxl-3 mb-md-5 mb-xl-10">


                    <div class="card card-flush h-md-50 mb-5 mb-xl-10" style="background-color: #E0FFFF;">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">

                                <span class="pt-1 fw-bold" style="font-size: 16px; color: black;">Total Product Stock</span>

                                <div class="d-flex align-items-center mt-2">
                                    <span class="fw-bolder me-2 lh-1" style="color: black; font-size: 23px;" >{{$totalStock}}</span>
                                    <!--end::Amount-->
                                </div>

                            </div>
                            <!--end::Title-->
                        </div>
                    </div>

                    
                    <!-- ******* blanck fields ********-->


                </div>


                



            </div>
            <!--end::Row-->
            

        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->

</div>

@endsection
