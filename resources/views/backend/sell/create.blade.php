@extends('backend.master')
@section('content')
    @section('title') Sell @endsection
    @section('sell') active @endsection
    @section('sell.create') active @endsection
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
                <h1 class="d-flex text-dark fw-bolder fs-3 align-items-center my-1">Sale Create

                    <!--end::Description-->
                </h1>
                <!--end::Title-->
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->

    <input type="hidden" value="{{ $sellingUniqueId }}" name="sellId" id="sellId">

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl card custom_card">
            <div class="row">
                <div class="col-md-6 border-right-2" id="updateSellList" style="position:relative;">

                    <div class="pay_button">
                        
                        
                    </div>
                    

                    <!-- table -->
                    <div class="card-body py-3">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th class="min-w-150px">Product</th>
                                        <th class="min-w-120px">Qyt</th>
                                        <th class="min-w-120px">Price</th>
                                        <th class="min-w-100px">Actions</th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table container-->
                    </div>
                </div>


                <div class="col-md-6" style="position: relative;">
                
                    <div class="row">

                        <div class="col-6 mb-3">
                            <select name="category_id" id="categoryID" data-control="select2"
                                class="form-select form-select-solid">
                                <option value="" disabled selected>Select Category</option>
                                @foreach($categories as $category)
                                    @if(isset($category))
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>

                        <div class="col-6 mb-3">
                            <select name="brand_id" id="brandId" data-control="select2"
                                class="form-select form-select-solid">
                                <option value="" disabled selected>Select Brand</option>
                                @foreach($brands as $brand)
                                    @if(isset($category))
                                        <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <div class="d-flex align-items-center mb-3">
                        <!--begin::Input group-->
                        <div class="position-relative custom_input me-md-2">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span
                                class="svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                        transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <input type="text" class="form-control form-control-solid ps-10 " name="search" id="search"
                                value="" placeholder="Search">
                        </div>
                        <!--end::Input group-->
                        <!--begin:Action-->
                        <div class="d-flex align-items-center">
                            <button type="submit" onclick="searchProduct()" class="btn btn-primary me-2">Search</button>
                            <button type="submit" onclick="resetSearch()" class="btn btn-danger">Reset</button>
                        </div>
                        <!--end:Action-->
                    </div>

                    <div class="product_item_wrap" id="filterProductList">
                        <div class="d-flex flex-wrap">

                            @foreach($products as $key=>$purchaseProduct)
                                @if(isset($purchaseProduct))

                                        @php
                                            $lastProductId = $purchaseProduct->id;

                                            if($key == 0){
                                                $firstProductId = $purchaseProduct->id;
                                            }
                                        @endphp
                                
                                    <div class="single_product">
                                        <a onclick="addSellProductDetails({{$purchaseProduct->id}})" >
                                        
                                            @if($purchaseProduct != null)
                                                <img
                                                    src="{{ asset('uploads/product_image/'.$purchaseProduct->product_image) }}"
                                                    alt="" style="height: 60px; width: 80px;">
                                            @else    
                                                <img
                                                        src="#"
                                                        alt="" style="height: 60px; width: 80px;">    
                                            @endif

                                            @if($purchaseProduct != null)
                                            <h4 class="mt-1">{{ $purchaseProduct->product_name }}</h4>
                                            @else
                                            <h4 class="mt-1">Null</h4>
                                            @endif
                                            
                                            @php
                                                $productStockData = App\Models\Stock::getProductStockCount($purchaseProduct->id);
                                            @endphp


                                            @if($productStockData != null)
                                                <h4>Qty - {{ $productStockData }} {{ $purchaseProduct->unitData->unit_name }}</h4>
                                            @else
                                                <h4>Qty - 0 {{ $purchaseProduct->unitData->unit_name }}</h4>
                                            @endif
                                        </a>
                                    </div>

                                    {{-- //To store prodctId into hidden field... --}}
                                    <input type="hidden" value="{{ $purchaseProduct->id }}"
                                        id="purchaseProductId{{$purchaseProduct->id}}" name="purchaseProductId{{$purchaseProduct->id}}">

                                @endif
                            @endforeach

                            @if(isset($lastProductId) && isset($firstProductId))
                                    <input type="hidden" id="firstProductId" value="{{$firstProductId}}">
                                    <input type="hidden" id="lastProductId" value="{{$lastProductId}}">
                                @endif


                        </div>
                    </div>


                    <div class="pagination">
                        
                        <button class="btn btn-sm" id="previous" onclick="previousProductData()" style="background-color: #eff2f5">Previous</button>
                        <button class="btn btn-sm" id="next" onclick="nextProductData()" style="margin-left: 10px; background-color: #eff2f5; ">Next</button>

                    </div>


                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Post-->
    </div>



    <div id="kt_engage_demos" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="explore"
        data-kt-drawer-activate="true" data-kt-drawer-overlay="true"
        data-kt-drawer-width="{default:'350px', 'lg': '475px'}" data-kt-drawer-direction="end"
        data-kt-drawer-toggle="#kt_engage_demos_toggle" data-kt-drawer-close="#kt_engage_demos_close">
        <!--begin::Card-->
        <div class="card shadow-none rounded-0 w-100">
            <!--begin::Header-->
            <div class="card-header" id="kt_engage_demos_header">
                <h3 class="card-title fw-bolder text-gray-700">Calculator</h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary h-40px w-40px me-n6"
                        id="kt_engage_demos_close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" id="kt_engage_demos_body">
                <!--begin::Content-->
                <div class="calc_wrapper">
                    <div class="">
                        <div class="first-row">
                            <div class="w-100">
                                <input type="text" name="result" class="form-control form-control-solid ps-10 "
                                    id="result" value="" placeholder="Result" readonly />
                            </div>
                            <button type="button" class="btn btn-danger" onclick="clearScreen()" id="clear">C</button>
                        </div>
                        <div class="second-row">
                            <input type="button" value="1" onclick="liveScreen(1)" id="one" />
                            <input type="button" value="2" onclick="liveScreen(2)" id="two" />
                            <input type="button" value="3" id="three" onclick="liveScreen(3)" />
                            <input type="button" value="+" onclick="liveScreen('+')" />
                        </div>
                        <div class="third-row">
                            <input type="button" value="4" id="four" onclick="liveScreen(4)" />
                            <input type="button" value="5" id="five" onclick="liveScreen(5)" />
                            <input type="button" value="6" id="six" onclick="liveScreen(6)" />
                            <input type="button" value="-" onclick="liveScreen('-')" />
                        </div>
                        <div class="fourth-row">
                            <input type="button" value="7" id="seven" onclick="liveScreen(7)" />
                            <input type="button" value="8" id="eight" onclick="liveScreen(8)" />
                            <input type="button" value="9" id="nine" onclick="liveScreen(9)" />
                            <input type="button" value="x" onclick="liveScreen('*')" />
                        </div>
                        <div class="fifth-row">
                            <input type="button" value="/" onclick="liveScreen('/')" />

                            <input type="button" value="0" id="zero" onclick="liveScreen(0)" />
                            <input type="button" value="." class="dot" onclick="liveScreen('.')" />
                            <button type="button" class="btn btn-primary cal_btn"
                                onclick="result.value = eval(result.value||null)">=</button>
                        </div>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>

    <div class="engage-toolbar d-flex position-fixed px-5 fw-bolder zindex-2 top-50 end-0 transform-90 mt-20 gap-2">
        <!--begin::Demos drawer toggle-->
        <button id="kt_engage_demos_toggle"
            class="engage-demos-toggle btn btn-flex h-35px bg-body btn-color-gray-700 btn-active-color-gray-900 shadow-sm fs-6 px-4 rounded-top-0"
            title="Calculator" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-dismiss="click"
            data-bs-trigger="hover">
            <span id="kt_engage_demos_label">Calculator</span>
        </button>
    </div>
  
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
        <span class="svg-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)"
                    fill="currentColor" />
                <path
                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                    fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon-->
    </div>



@endsection

@section('scripts')
    @include('backend.sell.partial.script')
    <script src="{{ asset('/backend/assets/js/custom/apps/projects/settings/settings.js') }}"></script>

    <script>
        $("#purchase_date").flatpickr()
    </script>


    <script>
        //To fetch nextPageProductData....
        function nextProductData() {
            event.preventDefault();
            var lastProductId = $("#lastProductId").val();

            var url = "{{ route('sell.next-page-product-data') }}";
            if (lastProductId != null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        lastProductId: lastProductId,
                    },
                    success: function (data) {
                        if(data.error){
                            alert(data.error);
                        }else{
                            $("#filterProductList").html(data);
                        }
                    }
                });
            } 
        }
       
        //To fetch previousPageProductData....
        function previousProductData() {
            event.preventDefault();
            var lastProductId = $("#firstProductId").val();

            var url = "{{ route('sell.previous-page-product-data') }}";
            if (lastProductId != null) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        lastProductId: lastProductId,
                    },
                    success: function (data) {
                        if(data.error){
                            alert(data.error);
                        }else{
                            $("#filterProductList").html(data);
                        }
                    }
                });
            } 
        }
    </script>
@endsection


