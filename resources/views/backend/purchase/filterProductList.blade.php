										
                <div class="product_item_wrap">
                        <div class="d-flex flex-wrap">

                            @foreach($products as $key=>$product)
                                @if(isset($product))

                                        @php
                                            $lastProductId = $product->id;

                                            if($key == 0){
                                                $firstProductId = $product->id;
                                            }
                                        @endphp

                                    <div class="single_product">
                                        <a href="javascript:void(0)" data-bs-toggle="modal"
                                            data-bs-target="#purchaseProductCreate{{$product->id}}"><img
                                                src="{{ asset('uploads/product_image/'.$product->product_image) }}"
                                                alt="" style="height: 60px; width: 80px;">
                                            <h4 class="mt-1">{{ $product->product_name }}</h4>
                                        </a>
                                    </div>

                                    {{-- //To store prodctId into hidden field... --}}
                                    <input type="hidden" value="{{ $product->id }}"
                                        id="productId{{$product->id}}" name="productId{{$product->id}}">

                                    {{-- For purchase product create modal... --}}
                                    <div class="modal" id="purchaseProductCreate{{$product->id}}" tabindex="-1"
                                        aria-modal="true" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered mw-1000px" id="kt_modal_new_target_form">
                                            <div class="modal-content d-block">

                                                <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#"
                                                    id="kt_modal_new_address_form">
                                                    <div class="modal-header" id="kt_modal_new_address_header">

                                                        <h2>Add Purchase</h2>
                                                        <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                            data-bs-dismiss="modal">

                                                            <span class="svg-icon svg-icon-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                                    <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                                        height="2" rx="1"
                                                                        transform="rotate(-45 6 17.3137)"
                                                                        fill="currentColor"></rect>
                                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                                        transform="rotate(45 7.41422 6)"
                                                                        fill="currentColor"></rect>
                                                                </svg>
                                                            </span>

                                                        </div>

                                                    </div>

                                                    <div class="modal-body py-10 px-lg-17">
                                                        <!--begin::Scroll-->
                                                        <div class="scroll-y me-n7 pe-7"
                                                            id="kt_modal_new_address_scroll" data-kt-scroll="true">


                                                            <div class="row mb-5">

                                                                <div class="col-md-4 fv-row fv-plugins-icon-container">
                                                                    <label class="required fs-5 fw-bold mb-2">Qyt - {{ $product->unitData->unit_name }}</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-solid"
                                                                        placeholder="" name="product_qty{{ $product->id }}"
                                                                        id="product_qty{{ $product->id }}" onblur="productQuantity({{ $product->id }})">
                                                                    <div
                                                                        class="fv-plugins-message-container invalid-feedback">
                                                                    </div>
                                                                </div>


                                                                <div class="col-md-4 fv-row fv-plugins-icon-container">

                                                                    <label
                                                                        class="fs-5 fw-bold mb-2">Free</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-solid"
                                                                        placeholder="" name="free_product{{ $product->id }}"
                                                                        id="free_product{{ $product->id }}" value="0"
                                                                        onblur="freeProductQuantity({{ $product->id }})">

                                                                    <div
                                                                        class="fv-plugins-message-container invalid-feedback">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 fv-row fv-plugins-icon-container">
                                                                    <label class="required fs-5 fw-bold mb-2">Total
                                                                        Product</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-solid"
                                                                        placeholder="" name="total_product{{ $product->id }}"
                                                                        id="total_product{{ $product->id }}" disabled>

                                                                    <div
                                                                        class="fv-plugins-message-container invalid-feedback">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer text-right" style="margin-right: 40px;">

                                                        <button type="reset" id="kt_modal_new_address_cancel"
                                                            class="btn btn-light me-3">Discard</button>

                                                        <button type="submit" id="kt_modal_new_address_submit"
                                                            class="btn btn-primary" onclick="addProductDetails({{ $product->id }})">
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
                                @endif
                            @endforeach

                            @if(isset($lastProductId) && isset($firstProductId))
                                    <input type="hidden" id="firstProductId" value="{{$firstProductId}}">
                                    <input type="hidden" id="lastProductId" value="{{$lastProductId}}">
                                @endif

                        </div>
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
        //To fetch nextPageProductData....
        function nextProductData() {
            event.preventDefault();
            var lastProductId = $("#lastProductId").val();

            var url = "{{ route('purchase.next-page-product-data') }}";
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

            var url = "{{ route('purchase.previous-page-product-data') }}";
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