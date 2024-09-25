<div class="pay_button">
    <!-- <button data-bs-toggle="modal" data-bs-target="#kt_modal_new_delete" type="submit"
        class="btn btn-danger me-2">Delete</button> -->
    <button  type="submit" onclick="modal()" class="btn btn-primary me-2">Pay Now</button>
</div>


<!-- payment modal -->
<div class="modal fade" id="payment" tabindex="-1" aria-modal="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2>Payment</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black"></rect>
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black"></rect>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5">
                <!--begin::Form-->
                <div id="kt_modal_new_card_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">

                    <table class=" table table-bordered custom-payment-table">
                        <thead>
                            <tr>
                                <th><strong>Paying Items:</strong> <span>({{ $totalProductQuantity }} )</span></th>
                                <th><strong>Total Price:</strong> <span
                                        id="paymentFinalProductPrice">({{ number_format($totalProductPrice) }} )</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><strong>Due Price:</strong></th>
                                <th><span id="finalCalculateAmount">({{ number_format($totalProductPrice) }} )</span></th>
                                <input type="hidden" id="finalDueAmount" value="{{ $totalProductPrice }}">
                            </tr>
                        </tbody>
                    </table>


                    <!--begin::Input group-->
                    <div class="row mt-15 mb-5 pb-5">
                        <div class="col-12 mb-10">
                            <label class="form-label" id="paymentNote">Payment Note</label>
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" name="" id="paymentNote" cols="30"
                                rows="3" placeholder="Enter Note (Optional)"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--begin::Col-->
                        <div class="col-6">
                            <label for="paymentType" class="form-label">Payment Method</label>
                            <select class="form-select" name="paymentType" data-control=""
                                data-placeholder="Select Supplier" id="paymentType">
                                <option value="hand cash">Hand Cash</option>
                                <option value="bank">Bank</option>
                                <option value="rocket">Rocket</option>
                                <option value="bkash">Bkash</option>
                                <option value="cash on delivery">Cash On Delivery</option>
                            </select>

                            @error('paymentType')
                                <span class=text-danger>{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-6">
                            <label for="paymentAmount" class="form-label">Payment Amount</label>
                            <input type="number" class=" form-control" name="paymentAmount" id="paymentAmount"
                                placeholder="Enter Amount" onblur="purchasePaymentAmount()">
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->

                    <!--begin::Actions-->
                    <div class="text-center pt-5 mt-5 float-end">
                        <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3 close"
                            data-bs-dismiss="modal">Cancle</button>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary"
                            onclick="savePurchasePayment()">
                            <span class="indicator-label">Submit</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                    <div></div>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>

                <div class="input-group">
                
                    <select name="supplier_id" id="supplier_id" aria-label="Select a Timezone" data-control="select2"
                        data-placeholder="Select Supplier" class="form-select form-select-solid">
                        <option value="" disabled selected>Select Supplier</option>

                        @foreach($suppliers as $supplier)
                        <option value="{{$supplier->id}}">{{$supplier->supplier_name}}</option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#addNewSupplier">
                                <span class="input-group-text" id="add-more-supplier"
                                    style="padding: 14px 15px;border-radius: 0px; background-color: #F0F8FF;">
                                <i class="la la-user-plus"></i>
                                </span>
                            </a>
                    </div>


                     {{-- For New Supplier Create Section Start... --}}
                                        <div class="modal fade" id="addNewSupplier" tabindex="-1" aria-modal="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <!--begin::Modal title-->
                                                        <h2>Add New Supplier</h2>
                                                        <!--end::Modal title-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                            data-bs-dismiss="modal">
                                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                            <span class="svg-icon svg-icon-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                        height="2" rx="1"
                                                                        transform="rotate(-45 6 17.3137)" fill="black">
                                                                    </rect>
                                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                        transform="rotate(45 7.41422 6)" fill="black">
                                                                    </rect>
                                                                </svg>
                                                            </span>
                                                            <!--end::Svg Icon-->
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>
                                                    <!--end::Modal header-->
                                                    <!--begin::Modal body-->
                                                    <div class="modal-body scroll-y mx-5">
                                                        <!--begin::Form-->
                                                        <div id="kt_modal_new_card_form"
                                                            class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                                            action="#">

                                                            <!--begin::Input group-->
                                                            <div class="row mb-5 pb-5">
                                                                <div class="col-lg-6 col-6 col-sm-6 col-12 mb-5">
                                                                    <label for="customerName"
                                                                        class="form-label">Name <span class=" text-danger">(required)</span> </label>
                                                                    <input type="text" class="form-control"
                                                                        name="supplier_name" id="supplierName"
                                                                        placeholder="Name">
                                                                </div>
                                                                <!--end::Col-->

                                                                <!--begin::Col-->
                                                                <div class="col-lg-6 col-6 col-sm-6 col-12 mb-5">
                                                                    <label for="customerEmail"
                                                                        class="form-label">Email</label>
                                                                    <input type="customer_email" class="form-control"
                                                                        name="supplier_email" id="supplierEmail"
                                                                        placeholder="Email">
                                                                </div>
                                                                <!--end::Col-->

                                                                <!--begin::Col-->
                                                                <div class="col-lg-6 col-6 col-sm-6 col-12 mb-5">
                                                                    <label for="customerPhone"
                                                                        class="form-label">Phone <span class=" text-danger">(required)</span> </label>
                                                                    <input type="text" class="form-control"
                                                                        name="supplier_phone" id="supplierPhone"
                                                                        placeholder="Phone Number">
                                                                </div>
                                                                <!--end::Col-->

                                                                <!--begin::Col-->
                                                                <div class="col-lg-6 col-6 col-sm-6 col-12 mb-5">
                                                                    <label for="customerCompany"
                                                                        class="form-label">Product or company Name</label>
                                                                    <input type="text" class="form-control"
                                                                        name="company_name" id="supplierCompany"
                                                                        placeholder="Company Name">
                                                                </div>
                                                                <!--end::Col-->

                                                                <div class="col-lg-12 col-12 col-sm-12 col-12 mb-5">
                                                                    <label for="note"
                                                                        class="form-label">Note</label>
                                                                    <input type="text" class="form-control"
                                                                        name="note" id="note"
                                                                        placeholder="Note">
                                                                </div>

                                                                <!--begin::Col-->
                                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                                                                    <label for="customerAddress"
                                                                        class="form-label">Address</label>
                                                                    <textarea class="form-control form-control-solid"
                                                                        name="supplier_address" id="supplierAddress" cols="30" rows="3"
                                                                        placeholder="Enter Address (Optional)"></textarea>
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Actions-->
                                                            <div class="text-center pt-5 float-end">
                                                                <button type="reset" id="kt_modal_new_card_cancel"
                                                                    class="btn btn-light me-3 close"
                                                                    data-bs-dismiss="modal">Cancle</button>
                                                                <button type="submit" id="kt_modal_new_card_submit"
                                                                    class="btn btn-primary" onclick="AddNewSuppllier()">
                                                                    <span class="indicator-label">Submit</span>
                                                                    <span class="indicator-progress">Please wait...
                                                                        <span
                                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                </button>
                                                            </div>
                                                            <!--end::Actions-->
                                                            <div></div>
                                                        </div>
                                                        <!--end::Form-->
                                                    </div>
                                                    <!--end::Modal body-->
                                                </div>
                                                <!--end::Modal content-->
                                            </div>
                                            <!--end::Modal dialog-->
                                        </div>
                                        {{-- For New Customer Create Section End... --}}

                </div>


<div class="card-body py-3">
    <!--begin::Table container-->
    <div class="table-responsive">
        <!--begin::Table-->
        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
            <!--begin::Table head-->
            <thead class=" bg-light">
                <tr class="fw-bolder text-muted">
                    <th class="min-w-150px">Product</th>
                    <th class="min-w-120px">Qyt</th>
                    <th class="min-w-120px">Free</th>
                    <th class="min-w-120px">Total</th>
                    <th class="min-w-120px">Price</th>
                    <th class="min-w-100px">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>

                <input type="hidden" id="selectedPurchaseId" value="{{ $selectedPurchaseId }}">

                @foreach($purchaseProductData as $data)
                    <tr>
                        <td>
                            <a 
                                class="text-dark fw-bolder text-hover-primary fs-6">{{ $data->productData->product_name }}</a>
                        </td>
                        <td class="text-dark fw-bolder text-hover-primary fs-6">{{ $data->product_qty }} {{ $data->productData->unitData->unit_name }}
                        </td>
                        <td>
                            <span class="text-dark fw-bolder text-hover-primary fs-6">{{ $data->free_product }} {{ $data->productData->unitData->unit_name }} </span>
                        </td>

                        <td class="text-dark fw-bolder text-hover-primary fs-6">{{ $data->total_product }} {{ $data->productData->unitData->unit_name }} </td>

                        <td class="text-dark fw-bolder text-hover-primary fs-6">{{ number_format($data->total_product_price) }} Tk
                        </td>


                        <td class="text-end">

                            <a href="javascript:void(0)" onclick="getAllData({{ $data->id }})" data-bs-toggle="modal"
                                data-bs-target="#purchaseProductEdit{{ $data->id }}"
                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">

                                <!--begin::Svg Icon | path: icons/duotune/art/art005.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path opacity="0.3"
                                            d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z"
                                            fill="currentColor" />
                                        <path
                                            d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>

                            <a href="#" onclick="deletePurchaseProduct({{ $data->id }})"
                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                        </td>
                    </tr>

                    <!-- purchase product edit modal -->
                    <div class="modal" id="purchaseProductEdit{{ $data->id }}" tabindex="-1" aria-modal="true"
                        role="dialog">
                        <div class="modal-dialog modal-dialog-centered mw-1000px">
                            <div class="modal-content d-block">

                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#"
                                    id="kt_modal_new_address_form">
                                    <div class="modal-header" id="kt_modal_new_address_header">

                                        <h2>Update Details</h2>
                                        <div class="btn btn-sm btn-icon btn-active-color-primary"
                                            data-bs-dismiss="modal">

                                            <span class="svg-icon svg-icon-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                                </svg>
                                            </span>

                                        </div>

                                    </div>

                                    <div class="modal-body py-10 px-lg-17">
                                        <!--begin::Scroll-->
                                        <div class="scroll-y me-n7 pe-7" id="kt_modal_new_address_scroll"
                                            data-kt-scroll="true">

                                            {{-- //To store purchaseProductId into hidden field... --}}
                                            <input type="hidden" value="{{ $data->id }}"
                                                id="purchaseProductId{{ $data->id }}"
                                                name="purchaseProductId{{ $data->id }}">


                                            <div class="row mb-5 p-0">

                                            
                                                <div class="col-md-4 fv-row fv-plugins-icon-container">
                                                    <label class="required fs-5 fw-bold mb-2">Qyt</label>
                                                    <input type="number" class="form-control form-control-solid"
                                                        placeholder="" name="product_qty{{ $data->id }}"
                                                        id="product_qty{{ $data->id }}"
                                                        onblur="productQuantity({{ $data->id }})">
                                                    <div class="fv-plugins-message-container invalid-feedback">
                                                    </div>
                                                </div>


                                                <div class="col-md-4 fv-row fv-plugins-icon-container">

                                                    <label class="required fs-5 fw-bold mb-2">Free</label>
                                                    <input type="number" class="form-control form-control-solid"
                                                        placeholder="" name="free_product{{ $data->id }}"
                                                        id="free_product{{ $data->id }}"
                                                        onblur="freeProductQuantity({{ $data->id }})">

                                                    <div class="fv-plugins-message-container invalid-feedback">
                                                    </div>
                                                </div>


                                                <div class="col-md-4 fv-row fv-plugins-icon-container">
                                                    <label class="required fs-5 fw-bold mb-2">Total
                                                        Product</label>
                                                    <input type="number" class="form-control form-control-solid"
                                                        placeholder="" name="total_product{{ $data->id }}"
                                                        id="total_product{{ $data->id }}" disabled>

                                                    <div class="fv-plugins-message-container invalid-feedback">
                                                    </div>
                                                </div>

                                            </div>

                                           
                                        </div>
                                    </div>

                                    <div class="modal-footer text-right" style="margin-right: 40px;">

                                        <button type="reset" id="kt_modal_new_address_cancel"
                                            class="btn btn-light me-3">Discard</button>

                                        <button type="submit" id="kt_modal_new_address_submit" class="btn btn-primary"
                                            onclick="updateProductDetails({{ $data->id }})">
                                            <span class="indicator-label">Submit</span>
                                            <span class="indicator-progress">Please wait...
                                                <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </button>

                                    </div>

                                    <div></div>
                                </form>

                            </div>
                        </div>
                    </div>

                @endforeach


                <tr>
                    <td></td>
                    <td></td>
                    
                    <td>Total-Qty:</td>
                    <td>
                        <p> <strong>{{ $totalProductQuantity }}</strong></p>
                        <input type="hidden" id="totalProductQuantity" value="{{ $totalProductQuantity }}">
                    </td>

                    <td>Grand-Total:</td>
                    <td>
                        <p><strong> <span id="grandTotalProductPrice">{{ number_format($totalProductPrice) }} </span></strong></p>
                        <input type="hidden" id="totalProductPrice" value="{{ $totalProductPrice }}">
                    </td>


                </tr>





            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Table container-->
</div>


<script
    src="{{ asset('/backend/assets/js/custom/apps/projects/settings/settings.js') }}">
</script>

<script>
    $("#purchase_date").flatpickr()
    $(".producut_menufacture_date").flatpickr()
    $(".product_expire_date").flatpickr()

</script>

<script>

    //add deatails modal on off...
    function modal(){
        let supplierId = $('#supplier_id').val();

        if (supplierId == null) {
            alert('Please select supplier first.!');
        }else{
           $("#payment").modal('show'); 
        }

    }

    //get purchase product data and fill the input form
    function getAllData(id) {

        var purchaseProductId = $("#purchaseProductId" + id).val();

        var url = "{{ route('get.purchase-deatils') }}";
        if (purchaseProductId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    purchaseProductId: purchaseProductId,
                },

                success: function (data) {
                    $("#product_qty" + id).val(data.product_qty);
                    $("#free_product" + id).val(data.free_product);
                    $("#total_product" + id).val(data.total_product);
                }
            });
        } else {

        }
    }



    //totalProductPrice calculation singleProductPrice
    /*function totalProductPrice(id) {

        //get single product price 
        let totalProductPrice = parseFloat($("#total_product_price" + id).val());
        let productQty = parseFloat($("#product_qty" + id).val());

        let singleProductPrice = totalProductPrice / productQty;

        if (productQty >= 0) {
            $("#single_product_price" + id).text(singleProductPrice);
            $("#single_product_price" + id).val(singleProductPrice);
        } else {
            $("#single_product_price" + id).text(0);
            $("#single_product_price" + id).val(0);
        }

    }*/


    //productQuantity calculation singleProductPrice and totalProduct
    function productQuantity(id) {

        //get single product price 
        /*let totalProductPrice = parseFloat($("#total_product_price" + id).val());
        

        let singleProductPrice = totalProductPrice / productQty;

        if (productQty >= 0) {
            $("#single_product_price" + id).text(singleProductPrice);
            $("#single_product_price" + id).val(singleProductPrice);
        } else {
            $("#single_product_price" + id).text(0);
            $("#single_product_price" + id).val(0);
        }*/


        //get total product 
        let productQty = parseFloat($("#product_qty" + id).val());
        let freeProduct = parseFloat($("#free_product" + id).val());
        let totalProduct = productQty + freeProduct;

        if (freeProduct >= 0) {
            $("#totalProduct" + id).text(totalProduct);
            $("#total_product" + id).val(totalProduct);
        } else {
            $("#totalProduct" + id).text(productQty);
            $("#total_product" + id).val(productQty);
        }

    }


    //freeProductQuantity calculation totalProduct
    function freeProductQuantity(id) {
        let productQty = parseFloat($("#product_qty" + id).val());
        let freeProduct = parseFloat($("#free_product" + id).val());
        let totalProduct = productQty + freeProduct;

        if (freeProduct >= 0) {
            $("#totalProduct" + id).text(totalProduct);
            $("#total_product" + id).val(totalProduct);
        } else {
            $("#totalProduct" + id).text(productQty);
            $("#total_product" + id).val(productQty);
        }

    }


    //purchase table addd supplier...
    $("#supplier_id").change(function () {
        var supplierId = $(this).val();
        let purchaseId = $("#selectedPurchaseId").val();

        var url = "{{ route('purchase-table-supplier-add') }}";
        if (supplierId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    supplierId: supplierId,
                    purchaseId: purchaseId
                },
                success: function (data) {
                    
                }
            });
        } 
    });


    //update product details ----
    function updateProductDetails(id) {
        event.preventDefault();

        var purchaseProductId = $("#purchaseProductId" + id).val();
        var productQty = $("#product_qty" + id).val();
        var freeProduct = $("#free_product" + id).val();
        var totalProduct = $("#total_product" + id).val();

        var url = "{{ route('update.product-deatils') }}";
        if (purchaseId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    purchaseProductId: purchaseProductId,
                    productQty: productQty,
                    freeProduct: freeProduct,
                    totalProduct: totalProduct,
                },

                success: function (data) {
                    alert('Success product updated to purchase list.');

                    //To purchase modal to hide...
                    $("#purchaseProductEdit" + purchaseProductId).modal('hide');
                    $("#updatePurchaseList").html(data);
                }
            });
        } else {

        }

    }


    //To remove the purchase product data from product list....
    function deletePurchaseProduct(id) {
        event.preventDefault();
        var purchaseProductId = id;
        var url = "{{ route('purchaseList.remove-product') }}";
        if (purchaseProductId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    purchaseProductId: purchaseProductId,
                },
                success: function (data) {
                    $("#updatePurchaseList").html(data);
                }
            });
        }
    }


    //To calculate purchase product amount...
    function purchasePaymentAmount() {
        let totalProductPrice = parseFloat($("#totalProductPrice").val());
        let paymentAmount = parseFloat($("#paymentAmount").val());
        
        if (paymentAmount >= 0) {
            let finalAmount = (totalProductPrice - paymentAmount);

            $("#finalCalculateAmount").text('(' + finalAmount + ')');
            $("#finalDueAmount").val(finalAmount);
        } else {
            $("#finalCalculateAmount").text('(' + totalProductPrice + ')');
            $("#finalDueAmount").val(totalProductPrice);
        }

    }


    //To save purchase payment data....
    function savePurchasePayment() {
        event.preventDefault();

        let selectedPurchaseId = $("#selectedPurchaseId").val();
        let totalProductQuantity = $("#totalProductQuantity").val();
        let totalProductAmount = parseFloat($("#totalProductPrice").val());
        let paidAmount = parseFloat($("#paymentAmount").val());
        let dueAmount = parseFloat($("#finalDueAmount").val());
        let paymentType = $("#paymentType").val();
        let paymentNote = $('textarea#paymentNote').val();
        let supplierId = $('#supplier_id').val();

        var url = "{{ route('purchase-payment') }}";
        if (selectedPurchaseId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    selectedPurchaseId: selectedPurchaseId,
                    totalProductQuantity: totalProductQuantity,
                    totalProductAmount: totalProductAmount,
                    paidAmount: paidAmount,
                    dueAmount: dueAmount,
                    paymentType: paymentType,
                    paymentNote: paymentNote,
                    supplierId: supplierId
                },
                success: function (data) {
                    if (data.success) {
                        $("#payment").modal('hide');
                        window.location.href = "/purchase-invoice/" + selectedPurchaseId;
                    } else {
                        console.log(data.error);
                        alert(data.error);
                    }
                }
            });
        }
    }



    //To add new Suppllier...
    function AddNewSuppllier() {
        let supplierName = $("#supplierName").val();
        let supplierEmail = $("#supplierEmail").val();
        let supplierPhone = $("#supplierPhone").val();
        let supplierCompany = $("#supplierCompany").val();
        let supplierAddress = $("#supplierAddress").val();
        let selectedPurchaseId = $("#selectedPurchaseId").val();
        let Note = $("#note").val();

        let url = "{{ route('purchase.add-new-supplier') }}";
        if (supplierName != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    supplierName: supplierName,
                    supplierEmail: supplierEmail,
                    supplierPhone: supplierPhone,
                    supplierCompany: supplierCompany,
                    supplierAddress: supplierAddress,
                    Note: Note,
                    purchaseId:selectedPurchaseId
                },
                success: function (data) {
                    $("#supplier_id").html(data);

                    $("#supplierName").val('');
                    $("#supplierEmail").val('');
                    $("#supplierPhone").val('');
                    $("#supplierCompany").val('');
                    $("#supplierAddress").val('');
                    $("#note").val('');

                    $("#addNewSupplier").modal('hide');
                }
            });
        }
    }

</script>
