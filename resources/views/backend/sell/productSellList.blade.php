<div class="pay_button">
   <!--  <button data-bs-toggle="modal" data-bs-target="#kt_modal_new_delete" type="submit"
        class="btn btn-danger me-2">Delete</button> -->
    <button type="submit" onclick="modal()" class="btn btn-primary me-2">Pay Now</button>
</div>


<!-- payment modal -->
<div class="modal fade" id="paymentSell" tabindex="-1" aria-modal="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
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
                                <th>
                                    <strong>Paying Items:</strong> <span> ({{ $totalProductQuantity }}) </span>
                                    <input type="hidden" id="totalProductQuantity" value="{{ $totalProductQuantity }}">
                                </th>

                                <th>
                                    <strong>Total Price:</strong> <span id="paymentFinalProductPrice">
                                         {{ number_format($totalProductPrice) }} </span>
                                    <input type="hidden" id="paymentFinalProductPriceInput"
                                        value="{{ $totalProductPrice }}">

                                    <input type="hidden" id="grandTotalProductPrice" value="{{ $totalProductPrice }}">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="dueTrBlock">
                                <th><strong>Due Price:</strong></th>
                                <th><span id="finalDueCalculateAmount">{{ number_format($totalProductPrice) }}</span></th>
                                <input type="hidden" id="finalDueCalculateAmountInput" value="{{ $totalProductPrice }}">
                            </tr>

                            <tr id="changeTrBlock" style="display: none;">
                                <th><strong>Change Price:</strong></th>
                                <th><span id="finalChangeCalculateAmount"> {{ number_format($totalProductPrice) }}</span></th>
                                <input type="hidden" id="finalChangeCalculateInputAmount" value="{{ $totalProductPrice }}">
                            </tr>

                        </tbody>
                    </table>

                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label" id="">Tax/Vat</label>
                            <input type="number" class="form-control form-control-solid" name="tax" id="sellingTax"
                                onblur="addTax()" value="0.00">
                        </div>

                        <div class="col-6">
                            <label class="form-label" id="">Discount</label>
                            <input type="number" class="form-control form-control-solid" name="discount"
                                id="sellingDiscount" value="0.00" onblur="addDiscount()">
                        </div>
                    </div>


                    <div class="row mt-2">
                        <div class="col-6">
                            <label class="form-label" id="">Special Discount</label>
                            <input type="number" class="form-control form-control-solid" name="special_discount"
                                id="sellingSpecialDiscount" value="0.00" onblur="addSpecialDiscount()">
                        </div>

                        <div class="col-6">
                            <label class="form-label" id="">Paid Amount</label>
                            <input type="number" class="form-control form-control-solid" name="paid_amount"
                                id="sellingPaidAmount" value="0.00" onblur="addPaidAmount()">
                        </div>
                    </div>


                    <!--begin::Input group-->
                    <div class="row mt-2 pb-5">
                        <div class="col-12 mb-10">
                            <label class="form-label" id="">Payment Note</label>
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" name="" id="paymentNote" cols="30"
                                rows="3" placeholder="Enter Note (Optional)"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--begin::Col-->
                    </div>
                    <!--end::Input group-->

                    <div class="row" style="margin-top: -40px;">
                        <div class="col-12">
                            <label for="paymentType" class="form-label">Payment Method</label>
                            <select class="form-select" name="paymentType" data-control=""
                                data-placeholder="Select Payment Method" id="paymentType">
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
                    </div>

                    <!--begin::Actions-->
                    <div class="text-center pt-5 mt-2 float-end">
                        <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3 close"
                            data-bs-dismiss="modal">Cancle</button>
                        <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary"
                            onclick="saveSellingPayment()">
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
    <select name="customer_id" id="customer_id" aria-label="Select a Timezone" data-control="select2" id="customer_id"
        class="form-select form-select-solid mt-2">
        <option value="" disabled selected>Select Customer</option>
        @foreach($customers as $customer)
         <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
        @endforeach

    </select>

    <div class="input-group-append">
        <a href="#" data-bs-toggle="modal" data-bs-target="#addNewCustomer">
            <span class="input-group-text" id="add-more-supplier"
                style="padding: 14px 15px;border-radius: 0px; margin-top: 7px; background-color: #F0F8FF;">
                <i class="la la-user-plus"></i>
            </span>
        </a>
    </div>


    {{-- For New Customer Create Section Start... --}}
    <div class="modal fade" id="addNewCustomer" tabindex="-1" aria-modal="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Add New Customer</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black">
                                </rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black">
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
                    <div id="kt_modal_new_card_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#">

                        <!--begin::Input group-->
                        <div class="row mb-5 pb-5">
                            <div class="col-lg-6 col-6 col-sm-6 col-12 mb-5">
                                <label for="customerName" class="form-label">Name <span
                                        class=" text-danger">(required)</span></label>
                                <input type="text" class="form-control" name="customer_name" id="customerName"
                                    placeholder="Name">
                            </div>
                            <!--end::Col-->

                        
                            <!--begin::Col-->
                            <div class="col-lg-6 col-6 col-sm-6 col-12 mb-5">
                                <label for="customerPhone" class="form-label">Phone <span
                                        class=" text-danger">(required)</span> </label>
                                <input type="text" class="form-control" name="customer_phone" id="customerPhone"
                                    placeholder="Phone Number">
                            </div>
                            <!--end::Col-->

                        
                            <!--begin::Col-->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-5">
                                <label for="customerAddress" class="form-label">Address</label>
                                <textarea class="form-control form-control-solid" name="" id="customerAddress" cols="30"
                                    rows="3" placeholder="Enter Address (Optional)"></textarea>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="text-center pt-5 float-end">
                            <button type="reset" id="kt_modal_new_card_cancel" class="btn btn-light me-3 close"
                                data-bs-dismiss="modal">Cancle</button>
                            <button type="submit" id="kt_modal_new_card_submit" class="btn btn-primary"
                                onclick="saveCustomer()">
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
    {{-- For New Customer Create Section End... --}}
</div>

<!-- table -->
<div class="card-body py-3">
    <!--begin::Table container-->
    <div class="table-responsive">
        <!--begin::Table-->
        <table class="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3">
            <!--begin::Table head-->
            <thead class="bg-light">
                <tr class="fw-bolder text-muted">
                    <th class="min-w-150px">Product</th>
                    <th class="min-w-150px">Qyt</th>
<!--                     <th class="min-w-120px">Price</th> -->
                    <th class="min-w-120px">Total Price</th>
                    <th class="min-w-100px">Actions</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>

                <input type="hidden" id="selectedSellingId" value="{{ $selectedSellingId }}">

                @if(isset($generatedNewSellingId) && $generatedNewSellingId != null)
                    <input type="hidden" id="generatedNewSellingId" value="{{ $generatedNewSellingId }}">
                @endif

                @foreach($sellingProductData as $data)
                    <tr>
                        <td>
                            <a href="#"
                                class="text-dark fw-bolder text-hover-primary fs-6">{{ $data->productData->product_name }}</a>
                        </td>

                        <td style="width: 200px;">
                            <div class="quantity">
                                <div role="group" class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="btn" style="padding: 0px 5px;font-size:25px;margin-top:-7px;color:#ed0000;"
                                            onclick="minusQty({{ $data->id }})">-</span>
                                    </div>
                                    <input type="number" class=" form-control" id="sellProductQty{{$data->id}}" value="{{$data->product_qty}}" style="padding: 1px 2px 1px 5px;
                                    text-align: center;margin-top:-3px;" onblur="addSellProductQty({{$data->id}})">
                                   
                                    <div class="input-group-append">
                                        <span class="btn " style="padding: 0px 2px;font-size:20px;margin-top:-3px;color:#00cf5b"
                                            onclick="plusQty({{ $data->id }})">+</span>
                                    </div>

                                    <span style="margin-left: 10px;">{{ $data->productData->unitData->unit_name }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- <td class="text-dark fw-bolder text-hover-primary fs-6"> {{ number_format($data->selling_price) }} 
                        </td> -->

                        <td class="text-dark fw-bolder text-hover-primary fs-6"> {{ number_format( $data->product_price) }} </td>

                        <td>
                            <a href="#" onclick="deleteSellProduct({{ $data->id }})"
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


                    {{-- //To store sellProductId into hidden field... --}}
                    <input type="hidden" value="{{ $data->id }}" id="sellProductId{{ $data->id }}"
                        name="sellProductId{{ $data->id }}">

                @endforeach


                <tr>
                    <td></td>
                    <td></td>
                    <td>
                        <p>Total-Qty: <strong>{{ $totalProductQuantity }}</strong></p>
                        <input type="hidden" id="totalProductQuantity" value="{{ $totalProductQuantity }}">
                    </td>
                    <td>
                        Grand-Total:
                    </td>
                    <td>
                        <p><strong> <span id="grandTotalProductPrice">{{ $totalProductPrice }}</span> </strong></p>
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

@section('scripts')
<script
    src="{{ asset('/backend/assets/js/custom/apps/projects/settings/settings.js') }}">
</script>
@endsection

<script>
    $("#purchase_date").flatpickr()
    $(".producut_menufacture_date").flatpickr()
    $(".product_expire_date").flatpickr()

</script>


<script>
    function modal() {
        let customerId = $('#customer_id').val();

        if (customerId == null) {
            alert('Please select and customer first.!');
        } else {
            $("#paymentSell").modal('show');
        }

    }


    //sell table addd cutomer...
    $("#customer_id").change(function () {
        var customerId = $(this).val();
        let selectedSellingId = $("#selectedSellingId").val();

        var url = "{{ route('sell-table-customer-add') }}";
        if (customerId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    customerId: customerId,
                    sellingId: selectedSellingId
                },
                success: function (data) {

                }
            });
        }
    });


    //To add sell product quantity...
    function plusQty(id) {
        event.preventDefault();
        var sellProductId = id;
        var url = "{{ route('increment.sell-product') }}";
        if (sellProductId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    sellProductId: sellProductId,
                },
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $("#updateSellList").html(data);
                    }
                }
            });
        }
    }

    //To decrease sell product quantity...
    function minusQty(id) {
        event.preventDefault();
        var sellProductId = id;
        var url = "{{ route('decrement.sell-product') }}";
        if (sellProductId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    sellProductId: sellProductId,
                },
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $("#updateSellList").html(data);
                    }
                }
            });
        }
    }
    
    //To add sell product quantity...
    function addSellProductQty(id) {
        event.preventDefault();
        var sellProductId = id;
        var sellProductQty = $("#sellProductQty"+sellProductId).val();
        var url = "{{ route('add-product-qty.sell-product') }}";
        if (sellProductId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    sellProductId: sellProductId,
                    sellProductQty: sellProductQty,
                },
                success: function (data) {
                    if(data.error){
                        alert(data.error);
                    }else{
                        $("#updateSellList").html(data);
                    }
                }
            });
        }
    }

    //To remove the sell product data from product list....
    function deleteSellProduct(id) {
        event.preventDefault();
        var sellProductId = id;
        var url = "{{ route('sellList.remove-product') }}";
        if (sellProductId != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    sellProductId: sellProductId,
                },
                success: function (data) {
                    $("#updateSellList").html(data);
                }
            });
        }
    }




    //To calculate price after adding tax/vat...
    function addTax() {
        let grandTotalProductPrice = parseFloat($("#grandTotalProductPrice").val());
        let sellingTax = parseFloat($("#sellingTax").val());
        let sellingDiscount = parseFloat($("#sellingDiscount").val());
        let sellingSpecialDiscount = parseFloat($("#sellingSpecialDiscount").val());
        let sellingPaidAmount = parseFloat($("#sellingPaidAmount").val());

        //To calculate the selling product price...
        calculateSellingProductPrice(grandTotalProductPrice, sellingTax, sellingDiscount, sellingSpecialDiscount,
            sellingPaidAmount);
    }

    //To calculate price after adding discount...
    function addDiscount() {
        let grandTotalProductPrice = parseFloat($("#grandTotalProductPrice").val());
        let sellingTax = parseFloat($("#sellingTax").val());
        let sellingDiscount = parseFloat($("#sellingDiscount").val());
        let sellingSpecialDiscount = parseFloat($("#sellingSpecialDiscount").val());
        let sellingPaidAmount = parseFloat($("#sellingPaidAmount").val());

        //To calculate the selling product price...
        calculateSellingProductPrice(grandTotalProductPrice, sellingTax, sellingDiscount, sellingSpecialDiscount,
            sellingPaidAmount);
    }

    //To calculate price after adding special-discount...
    function addSpecialDiscount() {
        let grandTotalProductPrice = parseFloat($("#grandTotalProductPrice").val());
        let sellingTax = parseFloat($("#sellingTax").val());
        let sellingDiscount = parseFloat($("#sellingDiscount").val());
        let sellingSpecialDiscount = parseFloat($("#sellingSpecialDiscount").val());
        let sellingPaidAmount = parseFloat($("#sellingPaidAmount").val());

        //To calculate the selling product price...
        calculateSellingProductPrice(grandTotalProductPrice, sellingTax, sellingDiscount, sellingSpecialDiscount,
            sellingPaidAmount);
    }


    //To calculate price after paid amount...
    function addPaidAmount() {
        let grandTotalProductPrice = parseFloat($("#grandTotalProductPrice").val());
        let sellingTax = parseFloat($("#sellingTax").val());
        let sellingDiscount = parseFloat($("#sellingDiscount").val());
        let sellingSpecialDiscount = parseFloat($("#sellingSpecialDiscount").val());
        let sellingPaidAmount = parseFloat($("#sellingPaidAmount").val());

        //To calculate the selling product price...
        calculateSellingProductPrice(grandTotalProductPrice, sellingTax, sellingDiscount, sellingSpecialDiscount,
            sellingPaidAmount);

    }

    //To calculate the selling product price...
    function calculateSellingProductPrice(grandTotalProductPrice, sellingTax, sellingDiscount, sellingSpecialDiscount,
        sellingPaidAmount) {
        if (sellingTax > 0) {
            var afterTaxPrice = Math.round(grandTotalProductPrice + sellingTax);
        } else {
            var afterTaxPrice = Math.round(grandTotalProductPrice + 0);
        }

        if (sellingDiscount > 0) {
            var afterDiscountPrice = Math.round(afterTaxPrice - sellingDiscount);
        } else {
            var afterDiscountPrice = Math.round(afterTaxPrice - 0);
        }

        if (sellingSpecialDiscount > 0) {
            var afterSpecialDiscountPrice = Math.round(afterDiscountPrice - sellingSpecialDiscount);
        } else {
            var afterSpecialDiscountPrice = Math.round(afterDiscountPrice - 0);
        }


        let subTotalPrice = afterSpecialDiscountPrice;
        $("#paymentFinalProductPrice").text(subTotalPrice);
        $("#paymentFinalProductPriceInput").val(afterSpecialDiscountPrice);

        if (sellingPaidAmount >= afterSpecialDiscountPrice) {

            var finalProductPrice = Math.round(sellingPaidAmount - afterSpecialDiscountPrice);
            let dueAmount = finalProductPrice;
            
            $("#dueTrBlock").hide();
            $("#changeTrBlock").show();

            $("#finalChangeCalculateAmount").text(dueAmount);
            $("#finalChangeCalculateInputAmount").val(dueAmount);

            $("#finalDueCalculateAmount").text(0);
            $("#finalDueCalculateAmountInput").val(0);

        }else{

            var finalProductPrice = Math.round(afterSpecialDiscountPrice - sellingPaidAmount);
            let dueAmount = finalProductPrice;

            $("#dueTrBlock").show();
            $("#changeTrBlock").hide();
            
           $("#finalDueCalculateAmount").text(dueAmount);
           $("#finalDueCalculateAmountInput").val(dueAmount);

           $("#finalChangeCalculateAmount").text(0);
            $("#finalChangeCalculateInputAmount").val(0);
        }

       

    }

    //To save selling payment data...
    function saveSellingPayment() {

        let customerId = $('#customer_id').val();

        if (customerId != null) {

            let selectedSellingId = $("#selectedSellingId").val();
            let totalProductQuantity = $("#totalProductQuantity").val();
            let totalProductAmount = parseFloat($("#grandTotalProductPrice").val());
            let sellingProductAmount = parseFloat($("#paymentFinalProductPriceInput").val());
            let sellingTax = parseFloat($("#sellingTax").val());
            let sellingDiscount = parseFloat($("#sellingDiscount").val());
            let sellingSpecialDiscount = parseFloat($("#sellingSpecialDiscount").val());
            let paidAmount = parseFloat($("#sellingPaidAmount").val());
            let dueAmount = parseFloat($("#finalDueCalculateAmountInput").val());
            let changeAmount = parseFloat($("#finalChangeCalculateInputAmount").val());
            let paymentType = $("#paymentType").val();
            let paymentNote = $('#paymentNote').val();



            var url = "{{ route('sell-payment') }}";
            if (selectedSellingId != '') {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        selectedSellingId: selectedSellingId,
                        totalProductQuantity: totalProductQuantity,
                        totalProductAmount: totalProductAmount,
                        sellingProductAmount: sellingProductAmount,
                        sellingTax: sellingTax,
                        sellingDiscount: sellingDiscount,
                        sellingSpecialDiscount: sellingSpecialDiscount,
                        paidAmount: paidAmount,
                        dueAmount: dueAmount,
                        changeAmount: changeAmount,
                        paymentType: paymentType,
                        paymentNote: paymentNote,
                        customerId: customerId
                    },
                    success: function (data) {
                        if (data.error) {
                            console.log(data.error);
                            alert(data.error);
                        } else {
                            $("#paymentSell").modal('hide');
                            $("#updateSellList").html(data);

                            //To get new generated selling id...
                            let generatedNewSellingId = $("#generatedNewSellingId").val();
                            $("#sellId").val(generatedNewSellingId);

                            //To load selling invoice page...
                            window.location.href = "/selling-invoice/" + selectedSellingId;
                        }
                    }
                });
            }
        } else {
            alert('Please select Customer Group first.!');
        }
    }

    //To add new customer...
    function saveCustomer() {
        let sellId = $("#sellId").val();
        let customerName = $("#customerName").val();
        let customerEmail = $("#customerEmail").val();
        let customerPhone = $("#customerPhone").val();
        let customerCompany = $("#customerCompany").val();
        let customerAddress = $("#customerAddress").val();

        let url = "{{ route('sell.add-new-customer') }}";
        if (customerName != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    sellId: sellId,
                    customerName: customerName,
                    customerEmail: customerEmail,
                    customerPhone: customerPhone,
                    customerCompany: customerCompany,
                    customerAddress: customerAddress,
                },
                success: function (data) {
                    $("#customer_id").html(data);
                    var customerId = $("#customer_id").val();
                     $("#addNewCustomer").modal('hide');
                }
            });
        }
    }

</script>
