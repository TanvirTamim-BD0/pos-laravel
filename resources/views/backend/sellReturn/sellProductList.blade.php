 <div class="card">
<div class="card-body pt-0 mb-4">

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed gy-5 dataTable no-footer"
                                id="groupDataTable">
                            <thead class="border-bottom border-gray-200 fs-7 fw-bolder">
                                <tr class="text-start text-muted text-uppercase gs-0">
                                    <th>SL</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Return Or Damage Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach($sellProducts as $sellProduct)
                                    @if(isset($sellProduct))
                                    <input type="hidden" id="sellingId" value="{{$sellProduct->selling_id}}">
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sellProduct->productData->product_name }}</td>

                                            <td>{{ $sellProduct->product_qty }}</td>
                                            <td>{{ $sellProduct->product_price }}</td>
                                            <td><input type="number" id="returnQty{{ $sellProduct->product_id }}" style="padding: 1px 2px 1px 5px; text-align: center;"></td>
                                            <td>
                                                <a class="btn btn-light btn-active-light-primary btn-sm" onclick="returnData( {{ $sellProduct->product_id }} )">Return </a>

                                                <a class="btn btn-light btn-active-light-primary btn-sm" onclick="damageModal({{$sellProduct->product_id}})" >Damage </a>
                                            </td>


                                            <div class="modal" id="damageModal{{$sellProduct->product_id}}" tabindex="-1"
                                            aria-modal="true" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered mw-650px" id="kt_modal_new_target_form">
                                                <div class="modal-content d-block">

                                                    <form class="form fv-plugins-bootstrap5 fv-plugins-framework" action="#"
                                                        id="kt_modal_new_address_form">
                                                        <div class="modal-header" id="kt_modal_new_address_header">

                                                            <h2>Sell Product Damage</h2>
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


                                                        <div class="modal-body py-10 px-lg-10">

                                                            <div class="row">
                                                                <div class="col-md-12 fv-row fv-plugins-icon-container">
                                                                    <label class="fs-5 fw-bold mb-2">Damage Note</span></label>
                                                                    <textarea 
                                                                        class="form-control" rows="4"
                                                                        placeholder="" name="note{{ $sellProduct->product_id }}"
                                                                        id="note{{ $sellProduct->product_id }}"
                                                                       ></textarea>

                                                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="modal-footer text-right" style="margin-right: 40px;">

                                                            <button type="reset" id="kt_modal_new_address_cancel"
                                                                class="btn btn-light me-3" data-bs-dismiss="modal">Discard</button>

                                                            <button type="submit" id="kt_modal_new_address_submit"
                                                                class="btn btn-primary" onclick="addDamageData({{ $sellProduct->product_id }})">
                                                                <span class="indicator-label">Add Damage</span>
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

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                          

                        </table>
                    </div>

                </div>
            </div>

        <script>
           function damageModal(id) {
                event.preventDefault();

               $("#damageModal"+id).modal('show');
            }
        </script>


        <script>
           function returnData(id){
                var productId = id;
                var sellingId = $("#sellingId").val();
                var returnQty = $("#returnQty" + id).val();
                
                var url = "{{ route('sellReturn.submit') }}";
                if(returnQty != '' ){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            productId: productId,
                            sellingId: sellingId,
                            returnQty: returnQty,
                        },
                        success: function (data) {
                            if(data.error){
                                alert(data.error);
                            }else{
                                window.location.href = "/sell-return";
                            }
                        }
                    });
                }else{
                    alert('Enter The Return Quantity !!')
                }
                
            }



            function addDamageData(id){
                var productId = id;
                var sellingId = $("#sellingId").val();
                var returnQty = $("#returnQty" + id).val();
                var note = $("#note" + id).val();
                
                var url = "{{ route('sellDamage.submit') }}";
                if(returnQty != '' ){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: {
                            productId: productId,
                            sellingId: sellingId,
                            returnQty: returnQty,
                            note: note,
                        },
                        success: function (data) {
                            if(data.error){
                                alert(data.error);
                            }else{
                                window.location.href = "/damage";
                            }
                        }
                    });
                }else{
                    alert('Enter The Damage Quantity !!')
                }
                
            }
        </script>