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
                                    <th>Return Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="fs-6 fw-bold text-gray-600">
                                @foreach($purchaseProducts as $purchaseProduct)
                                    @if(isset($purchaseProduct))
                                    <input type="hidden" id="purchaseId" value="{{$purchaseProduct->purchase_id}}">
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $purchaseProduct->productData->product_name }}</td>

                                        
                                            <td>{{ $purchaseProduct->total_product }}</td>
                                            <td>{{ $purchaseProduct->total_product_price }}</td>
                                            <td><input type="number" id="returnQty{{ $purchaseProduct->product_id }}" style="padding: 1px 2px 1px 5px; text-align: center;"></td>
                                            <td>
                                                <a class="btn btn-light-danger btn-active-light-primary btn-sm" onclick="returnData( {{ $purchaseProduct->product_id }} )">Return </a>
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                          

                        </table>
                    </div>

                </div>
            </div>


        <script>
           function returnData(id){
                var productId = id;
                var purchaseId = $("#purchaseId").val();
                var returnQty = $("#returnQty" + id).val();
                
                var url = "{{ route('purchaseReturn.submit') }}";
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
                            purchaseId: purchaseId,
                            returnQty: returnQty,
                        },
                        success: function (data) {
                            if(data.error){
                                alert(data.error);
                            }else{
                                window.location.href = "/purchase-return";
                            }
                        }
                    });
                }else{
                    alert('Enter The Return Quantity !!')
                }
                
            }
        </script>